<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Alarm;
use AsteriosBot\Core\Connection\Repository;

class Checker
{
    /**
     * @param string $server
     */
    public function execute(string $server)
    {
        $repo = Repository::getInstance();
        $sender = new Alarm();
        $local = $repo->getDataPDOid(ServerConstants::NAMES_TO_ID[$server]);
        $dead = $repo->getDeadRB($local);
    
        $records = array_filter(array_map(function (&$x) {
            if ($x['timestamp'] > 0) {
                return $x;
            } else return null;
        }, $dead));
    
        foreach ($records as $record) {
            $time = $record['timestamp'];
            $respawn = $repo->checkRespawnTime($time, $record['name']);
            if ($respawn > 0) {
                $sender->alarm($record, $respawn);
            }
        }
    }
}
