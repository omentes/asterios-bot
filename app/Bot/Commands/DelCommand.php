<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommand;

use AsteriosBot\Bot\NotificationHandler;
use AsteriosBot\Core\Connection\Metrics;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Prometheus\Exception\MetricsRegistrationException;

/**
 * Add command
 *
 * Add subscribe to notifications
 */
class DelCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'del';
    /**
     * @var string
     */
    protected $description = 'Del command';
    /**
     * @var string
     */
    protected $usage = '/del <server> <boss>';
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
        $message = $this->getMessage();
        $chatId = $message->getChat()->getId();
        $text = $message->getText(true);
        $command = new NotificationHandler($chatId, $text, false);
        $data = [
            'chat_id' => $chatId,
            'text' => $command->getMessage(),
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
        ];
        return Request::sendMessage($data);
    }
}
