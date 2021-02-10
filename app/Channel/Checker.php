<?php

declare(strict_types=1);

namespace AsteriosBot\Channel;

use AsteriosBot\Channel\Sender\Alarm;
use AsteriosBot\Channel\Sender\Notify;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\BadServerException;
use AsteriosBot\Core\Support\Config;
use Monolog\Logger;
use Prometheus\Exception\MetricsRegistrationException;

class Checker extends Channel
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
     * @throws MetricsRegistrationException
     */
    public function execute(string $serverName)
    {
        $serverId = $this->config->getServerId($serverName);
        $local = $this->repository->getDeadRaidBossesWithId($serverId);
        $records = $this->repository->getRaidBossesWithRespawnTime($local);
        foreach ($records as $record) {
            $respawn = $this->repository->checkRespawnTime($record['timestamp'], $record['name']);
            if ($respawn > 0) {
                $this->sender->notify($record, $serverId);
            }
        }
        $this->metrics->increaseHealthCheck('_checker' . $serverName);
    }
}
