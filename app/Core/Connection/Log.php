<?php
declare(strict_types = 1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Support\Singleton;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Exception;

class Log extends Singleton
{
    private $logger;
    
    protected function __construct()
    {
        $logger = new Logger('app');
        $logPath = getenv('LOG_PATH');
        try {
            $logger->pushHandler(new StreamHandler($logPath . 'app.log', Logger::ERROR));
            $logger->pushHandler(new StreamHandler($logPath . 'debug.log', Logger::DEBUG));
        } catch (Exception $e) {
            $logger->error($e->getMessage());
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
