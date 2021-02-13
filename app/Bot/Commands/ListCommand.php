<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommand;

use AsteriosBot\Bot\ListHandler;
use AsteriosBot\Bot\NotificationHandler;
use AsteriosBot\Core\Connection\Metrics;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;
use Prometheus\Exception\MetricsRegistrationException;

/**
 * List command
 *
 * Add subscribe to notifications
 */
class ListCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'list';
    /**
     * @var string
     */
    protected $description = 'List command';
    /**
     * @var string
     */
    protected $usage = '/list';
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
        $command = new ListHandler($chatId);
        $data = [
            'chat_id' => $chatId,
            'text' => $command->getMessage(),
            'parse_mode' => 'markdown',
            'disable_web_page_preview' => true,
        ];
        return Request::sendMessage($data);
    }
}
