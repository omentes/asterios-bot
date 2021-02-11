<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Support\Singleton;
use Monolog\Formatter\LineFormatter;
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
     * @var Logger
     */
    private Logger $botLogger;

    protected function __construct()
    {
        $this->logger = new Logger('app');
        $this->botLogger = new Logger('bot');
        $logPath = getenv('LOG_PATH');
        try {
            $this->logger->pushHandler(new StreamHandler($logPath . 'app.log', Logger::ERROR));
            $this->logger->pushHandler(new StreamHandler($logPath . 'debug.log', Logger::DEBUG));
            $this->botLogger->pushHandler(new StreamHandler($logPath . 'bot.log', Logger::ERROR));
            $this->botLogger->pushHandler(new StreamHandler($logPath . 'bot.log', Logger::INFO));
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

    /**
     * @return Logger
     */
    public function getBotLogger(): Logger
    {
        return $this->botLogger;
    }
}
