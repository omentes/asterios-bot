<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot;

use AsteriosBot\Bot\Sender\Notify;
use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use Monolog\Logger;

abstract class Bot
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
        $this->metrics = !is_null($metrics) ? $metrics : Metrics::getInstance()->getRegistry();
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
        $this->logger = !is_null($logger) ? $logger : Log::getInstance()->getLogger();
    }
}
