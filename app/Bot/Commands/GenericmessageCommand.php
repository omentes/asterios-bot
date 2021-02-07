<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use AsteriosBot\Bot\BotHelper;
use AsteriosBot\Bot\RaidDTO;
use AsteriosBot\Bot\RaidInfoHandler;
use AsteriosBot\Core\App;
use AsteriosBot\Core\Support\ArrayHelper;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Conversation;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class GenericmessageCommand extends SystemCommand
{
    protected $name = 'genericmessage';
    protected $description = 'Handle generic message';
    protected $version = '1.0.0';

    /**
     * @return ServerResponse
     * @throws TelegramException
     */
    public function execute(): ServerResponse
    {
        $text = trim($this->getMessage()->getText(true));
        $chat_id = $this->getMessage()->getChat()->getId();
        try {
            $dto = $this->parseText($text);

            $keyboard = new Keyboard(...BotHelper::getKeyboard());
            $keyboard->setResizeKeyboard(true);
            $data = [
                'chat_id' => $chat_id,
                'text' => (new RaidInfoHandler($dto))->getText(),
                'parse_mode' => 'markdown',
                'disable_web_page_preview' => true,
                'reply_markup' => $keyboard,
            ];
            return Request::sendMessage($data);
        } catch (\Exception $e) {
        }
        return Request::emptyResponse();
    }

    /**
     * @param $text
     *
     * @return RaidDTO
     * @throws \Exception
     */
    private function parseText($text): RaidDTO
    {
        if (!in_array($text, BotHelper::TEXT_QUESTIONS)) {
            throw new \Exception();
        }

        $x5flag = strpos($text, 'x5');
        $slug = BotHelper::getRaidName($text);
        $serverName = $x5flag === false ? 'x3' : 'x5';
        $serverId = App::getInstance()->getConfig()->getServerId($serverName);
        return new RaidDTO($serverId, $slug);
    }
}
