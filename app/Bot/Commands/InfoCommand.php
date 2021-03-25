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
 * Info Command
 *
 * Gets executed when a user first starts using the bot.
 */
class InfoCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'info';
    /**
     * @var string
     */
    protected $description = 'info command';
    /**
     * @var string
     */
    protected $usage = '/info';
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
            'text' => $this->getText(),
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
            'reply_markup' => $keyboard,
        ];
        return Request::sendMessage($data);
    }

    private function getText(): string
    {
        return "Если у ваших друзей нет телеграма и вы хотите поделиться информацией с этого бота, просто отправьте"
            . "им ссылку https://asterios.webhook.pp.ua/?server=x5&html x5 Можно заменить на x3/x7.\n\nЭта html "
            . "страничка адаптирована к мобильным устройствам.\n\nТак же есть изоброжание по ссылкке "
            . " https://asterios.webhook.pp.ua/?server=x5 или https://asterios.webhook.pp.ua/?server=x5&color=dark "
            . " и тут так-же можно заменить сервер прямо в ссылке на x3/x7\n\n"
            . "А так же каналы:\n"
            . "для сервера x3\n@asteriosx3rb - сабовые, Кабрио и ТоИ\n@asteriosX3keyRB - все остальные с фида\n"
            . "для сервера x5:\n@asteriosx5rb - сабовые, Кабрио и ТоИ\n@asteriosX5keyRB - все остальные с фида\n"
            . "для сервера x7:\n@asteriosx7rb  - сабовые, Кабрио и ТоИ\n@asteriosX7keyRB- все остальные с фида\n";
    }
}
