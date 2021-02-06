<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Death;
use AsteriosBot\Bot\Sender\Notify;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\ArrayHelper;
use AsteriosBot\Core\Support\ServerConstants;
use Monolog\Logger;
use Prometheus\Exception\MetricsRegistrationException;

class Parser extends Bot
{

    
    /**
     * Checker constructor.
     *
     * @param Notify|null     $sender
     * @param Metrics|null    $metrics
     * @param Repository|null $repository
     * @param Logger|null     $logger
     */
    public function __construct(
        Notify $sender = null,
        Metrics $metrics = null,
        Repository $repository = null,
        Logger $logger = null
    ) {
        $this->sender = !is_null($sender) ? $sender : new Death();
        parent::__construct();
    }
    
    /**
     * @param string $serverName
     *
     * @throws MetricsRegistrationException
     */
    public function execute(string $serverName): void
    {
        $serverId = ServerConstants::NAMES_TO_ID[$serverName];
        $local = $this->repository->getDataPDO($serverId, 30);
        $remote = $this->repository->getRSSData(ServerConstants::URLS[$serverId], 30);
        $newRaids = ArrayHelper::arrayRecursiveDiff($remote, $local);
        $counter = count($remote);
        $this->logger->debug("[$serverName]: $counter", $newRaids);
        if ($counter) {
            $this->metrics->increaseHealthCheck($serverName);
        }
        foreach ($newRaids as $raid) {
            $this->sender->notify($raid, $serverId);
        }
    }
}
