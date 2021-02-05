<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Death;
use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\ArrayHelper;

class Runner
{
    
    /**
     * @param string $server
     *
     * @throws \Prometheus\Exception\MetricsRegistrationException
     */
    public function execute(string $server): void
    {
        $repo = Repository::getInstance();
        $sender = new Death();
        $serverId = ServerConstants::NAMES_TO_ID[$server];
        $local = $repo->getDataPDO($serverId, 30);
        $remote = $repo->getRSSData(ServerConstants::URLS[$serverId], 30);
        $newRaids = ArrayHelper::arrayRecursiveDiff($remote, $local);
        $counter = count($remote);
        Log::getInstance()->getLogger()->debug("[$server]: $counter", $newRaids);
        if ($counter) {
            \Prometheus\Storage\Redis::setDefaultOptions(
                [
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'password' => null,
                    'timeout' => 0.1, // in seconds
                    'read_timeout' => '10', // in seconds
                    'persistent_connections' => false
                ]
            );
            $registry = \Prometheus\CollectorRegistry::getDefault();
            $counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_x5', 'it increases');
            $counter->incBy(1, []);
        }
        foreach ($newRaids as $raid) {
            $sender->deathMessage($raid, $serverId);
        }
    }
}
