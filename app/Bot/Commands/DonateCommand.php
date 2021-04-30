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
 * Donate command
 *
 * Gets executed when a user first starts using the bot.
 */
class DonateCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'donate';
    /**
     * @var string
     */
    protected $description = 'Donate command';
    /**
     * @var string
     */
    protected $usage = '/donate';
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
        $keyboard = new Keyboard(...BotHelper::getKeyboardDonate());
        $keyboard->setResizeKeyboard(true);
        $data = [
            'chat_id' => $chat_id,
            'text' => 'Вы можете оплатить сервер для бота. Воспользуйтесь кнопкой для выбора. Услуги предоставляются согласно пользовательскому соглашению, которое доступно по ссылке https://asterios.webhook.pp.ua/?terms',
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
            'reply_markup' => $keyboard,
        ];
        return Request::sendMessage($data);
    }
}
