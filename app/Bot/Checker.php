<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Alarm;
use AsteriosBot\Bot\Sender\Notify;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\BadServerException;
use AsteriosBot\Core\Support\ArrayHelper;
use AsteriosBot\Core\Support\Config;
use Monolog\Logger;

class Checker extends Bot
{
    /**
     * Checker constructor.
     *
     * {@inheritDoc}
     */
    public function __construct(
        Notify $sender = null,
        Metrics $metrics = null,
        Repository $repository = null,
        Config $config = null,
        Logger $logger = null
    ) {
        $this->sender = !is_null($sender) ? $sender : new Alarm();
        parent::__construct(
            $this->sender,
            $metrics,
            $repository,
            $config,
            $logger
        );
    }

    /**
     * @param string $serverName
     *
     * @throws BadServerException
     */
    public function execute(string $serverName)
    {
        $serverId = $this->config->getServerId($serverName);
        $local = $this->repository->getDeadRaidBossesWithId($serverId);
        $dead = $this->repository->getRaidBossesWithRespawnTime($local);
        $records = ArrayHelper::filterDeadRaidBosses($dead);
        foreach ($records as $record) {
            $respawn = $this->repository->checkRespawnTime($record['timestamp'], $record['name']);
            if ($respawn > 0) {
                $this->sender->notify($record, $serverId);
            }
        }
    }
}
