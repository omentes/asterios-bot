<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommand;

use AsteriosBot\Bot\BotHelper;
use AsteriosBot\Core\Connection\Metrics;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Prometheus\Exception\MetricsRegistrationException;

/**
 * Start command
 *
 * Gets executed when a user first starts using the bot.
 */
class StartCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'start';
    /**
     * @var string
     */
    protected $description = 'Start command';
    /**
     * @var string
     */
    protected $usage = '/start';
    /**
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * @var bool
     */
    protected $private_only = true;

    /**
     * Command execute method
     *
     * @return ServerResponse
     * @throws TelegramException
     * @throws MetricsRegistrationException
     */
    public function execute(): ServerResponse
    {
        Metrics::getInstance()->increaseMetric('usage');
        $chat_id = $this->getMessage()->getChat()->getId();
        $keyboard = new Keyboard(...BotHelper::getKeyboardServers());
        $keyboard->setResizeKeyboard(true);
        $data = [
            'chat_id' => $chat_id,
            'text' => 'Привет! Я умею показывать время до респауна сабовых РБ на серверах Астериоса.
Информация берется с их офф сайта, поэтому если у самого Астериоса проблемы - тут тоже может быть неточная информация.
Этот бот - дополнение к каналам, куда публикуются сообщения во время смерти РБ. Подробнее тут https://t.me/asteriosx5rb/3451
Так же у меня можно подписать на конкретного РБ, как только по нему будет событие (старт респа, смерть и тд) - я напишу тебе
Подробнее /list',
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
            'reply_markup' => $keyboard,
        ];
        return Request::sendMessage($data);
    }
}
