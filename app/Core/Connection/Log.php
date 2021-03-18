<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Support\Singleton;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class Log extends Singleton
{
    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * Log constructor.
     */
    protected function __construct()
    {
        $config = App::getInstance()->getConfig();
        $this->logger = new Logger('app');
        $logPath = $config->getLogPath();
        try {
            $this->logger->pushHandler(new StreamHandler($logPath . 'app.log', Logger::WARNING));
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            return;
        }
    }

    /**
     * @return Logger
     */
    public function getLogger(): Logger
    {
        return $this->logger;
    }
}
