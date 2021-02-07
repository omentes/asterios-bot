<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Exception\EnvironmentException;
use AsteriosBot\Core\Support\Singleton;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use Prometheus\Exception\MetricsRegistrationException;

class Bot extends Singleton
{
    /**
     * @var Telegram
     */
    private $telegram;

    protected function __construct()
    {
        $config = App::getInstance()->getConfig();
        try {
            $bot_api_key = $config->getTelegramToken();
            $bot_username = $config->getTelegramBotName();
            $dto = $config->getDatabaseDTO();
            $this->telegram = new Telegram($bot_api_key, $bot_username);
            TelegramLog::initialize(Log::getInstance()->getBotLogger());
            $this->telegram->enableAdmin($config->getTelegramAdminId());
            $this->telegram->addCommandsPaths(['/app/app/Bot/Commands',]);
            $this->telegram->enableMySql([
                'host'     => $dto->getHost(),
                'user'     => $dto->getUser(),
                'password' => $dto->getPassword(),
                'database' => $dto->getName(),
            ]);
        } catch (EnvironmentException | TelegramException $e) {
            Log::getInstance()->getBotLogger()->error($e->getMessage(), $e->getTrace());
        }
    }
    
    /**
     *
     * @throws MetricsRegistrationException
     */
    public function run(): void
    {
        try {
            $this->telegram->handleGetUpdates();
            Metrics::getInstance()->increaseHealthCheck('bot');
        } catch (TelegramException $e) {
            Log::getInstance()->getBotLogger()->error($e->getMessage(), $e->getTrace());
        }
    }
}
