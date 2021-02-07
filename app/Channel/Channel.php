<?php

declare(strict_types=1);

namespace AsteriosBot\Channel;

use AsteriosBot\Channel\Sender\Notify;
use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\Config;
use Monolog\Logger;

abstract class Channel
{
    /**
     * @var Notify
     */
    protected $sender;

    /**
     * @var Metrics
     */
    protected $metrics;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Checker constructor.
     *
     * @param Notify|null     $sender
     * @param Metrics|null    $metrics
     * @param Repository|null $repository
     * @param Config|null     $config
     * @param Logger|null     $logger
     */
    public function __construct(
        Notify $sender = null,
        Metrics $metrics = null,
        Repository $repository = null,
        Config $config = null,
        Logger $logger = null
    ) {
        $this->metrics = !is_null($metrics) ? $metrics : Metrics::getInstance();
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
        $this->logger = !is_null($logger) ? $logger : Log::getInstance()->getLogger();
        $this->config = !is_null($config) ? $config : App::getInstance()->getConfig();
    }
}
