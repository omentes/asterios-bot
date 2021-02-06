<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Alarm;
use AsteriosBot\Bot\Sender\Notify;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\ServerConstants;
use Monolog\Logger;

class Checker extends Bot
{
    public function __construct(
        Notify $sender = null,
        Metrics $metrics = null,
        Repository $repository = null,
        Logger $logger = null
    ) {
        $this->sender = !is_null($sender) ? $sender : new Alarm();
        parent::__construct();
    }
    
    /**
     * @param string $serverName
     */
    public function execute(string $serverName)
    {
        $local = $this->repository->getDataPDOid(ServerConstants::NAMES_TO_ID[$serverName]);
        $dead = $this->repository->getDeadRB($local);
        $serverId = ServerConstants::NAMES_TO_ID[$serverName];
        $records = array_filter(array_map(function (&$x) {
            if ($x['timestamp'] > 0) {
                return $x;
            } else return null;
        }, $dead));
    
        foreach ($records as $record) {
            $respawn = $this->repository->checkRespawnTime($record['timestamp'], $record['name']);
            if ($respawn > 0) {
                $this->sender->notify($record, $serverId);
            }
        }
    }
}
