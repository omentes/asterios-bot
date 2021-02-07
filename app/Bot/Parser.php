<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Death;
use AsteriosBot\Bot\Sender\Notify;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\BadServerException;
use AsteriosBot\Core\Support\ArrayHelper;
use AsteriosBot\Core\Support\Config;
use Monolog\Logger;
use Prometheus\Exception\MetricsRegistrationException;

class Parser extends Bot
{
    /**
     * Parser constructor.
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
        $this->sender = !is_null($sender) ? $sender : new Death();
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
     * @throws MetricsRegistrationException
     * @throws BadServerException
     */
    public function execute(string $serverName): void
    {
        $serverId = $this->config->getServerId($serverName);
        $local = $this->repository->getDeadRaidBosses($serverId, 20);
        $url = $this->config->getRSSUrl($serverId);
        $remote = $this->repository->getRSSFeedByUrl($url, 20);
        $newRaids = ArrayHelper::arrayDiff($remote, $local);
        $counter = count($newRaids);
        $this->logger->debug("[$serverName]: $counter", $newRaids);
        if ($counter) {
            $this->metrics->increaseHealthCheck($serverName);
        }
        foreach ($newRaids as $raid) {
            $this->sender->notify($raid, $serverId);
        }
    }
}
