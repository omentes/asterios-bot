<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Metrics;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\EnvironmentException;
use AsteriosBot\Core\Support\Singleton;
use Longman\TelegramBot\Entities\Chat;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\TelegramLog;
use Prometheus\Exception\MetricsRegistrationException;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\Message;

class Bot extends Singleton
{
    /**
     * @var Telegram
     */
    private Telegram $telegram;

    protected function __construct()
    {
        $config = App::getInstance()->getConfig();
        try {
            $bot_api_key = $config->getTelegramToken();
            $bot_username = $config->getTelegramBotName();
            $dto = $config->getDatabaseDTO();
            $this->telegram = new Telegram($bot_api_key, $bot_username);
            TelegramLog::initialize(Log::getInstance()->getLogger());
            $this->telegram->enableAdmin($config->getTelegramAdminId());
            $this->telegram->addCommandsPaths(['/app/app/Bot/Commands',]);
            $this->telegram->enableMySql(
                [
                'host'     => $dto->getHost(),
                'user'     => $dto->getUser(),
                'password' => $dto->getPassword(),
                'database' => $dto->getName(),
                ]
            );
            $this->checkVersion();
        } catch (EnvironmentException | TelegramException $e) {
            Log::getInstance()->getLogger()->error($e->getMessage(), $e->getTrace());
        }
    }

    /**
     *
     * @throws MetricsRegistrationException
     */
    public function run(): void
    {
        $notify = new Notify();
        try {
            $this->telegram->handleGetUpdates();
            $notify->handle();
            Metrics::getInstance()->increaseHealthCheck('bot');
        } catch (TelegramException $e) {
            Log::getInstance()->getLogger()->error($e->getMessage(), $e->getTrace());
        }
    }

    /**
     * @throws TelegramException
     */
    private function checkVersion(): void
    {
        /** @var Repository $repository */
        $repository = Repository::getInstance();
        $version = $repository->getNewLatestVersion();
        if (!empty($version)) {
            $keyboard = new Keyboard(...BotHelper::getKeyboardServers());
            $keyboard->setResizeKeyboard(true);

            $results = Request::sendToActiveChats(
                'sendMessage',
                [
                    'text' => $version['description'],
                    'parse_mode' => 'markdown',
                    'disable_web_page_preview' => true,
                    'reply_markup' => $keyboard,
                ],
                [
                    'groups' => true,
                    'supergroups' => true,
                    'channels' => false,
                    'users' => true,
                ]
            );
            foreach ($results as $result) {
                if ($result->isOk()) {
                    /** @var Message $message */
                    $message = $result->getResult();
                    $chat = $message->getChat() ;
                    if (!empty($chat)) {
                        /** @var Chat $chat */
                        $chatId = $chat->getId();
                        try {
                            $repository->saveVersionNotification($chatId, $version['id']);
                        } catch (\Throwable $e) {
                            Log::getInstance()->getLogger()->error($e->getMessage(), $e->getTrace());
                        }
                    }
                }
            }
            $repository->applyVersion($version['id']);
        }
    }
}
