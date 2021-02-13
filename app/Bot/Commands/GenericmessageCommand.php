<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommands;

use AsteriosBot\Bot\BotHelper;
use AsteriosBot\Bot\AnswerDTO;
use AsteriosBot\Bot\AnswerHandler;
use AsteriosBot\Core\App;
use AsteriosBot\Core\Exception\BadServerException;
use Longman\TelegramBot\Commands\SystemCommand;
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
            $keyboard = $this->getKeyboard($dto->getServerName());
            $keyboard->setResizeKeyboard(true);
            $data = [
                'chat_id' => $chat_id,
                'text' => (new AnswerHandler($dto))->getText(),
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
     *
     * @param string $text
     *
     * @return AnswerDTO
     * @throws BadServerException
     */
    private function parseText(string $text): AnswerDTO
    {
        if (!in_array($text, BotHelper::AVAILABLE_INPUTS)) {
            return new AnswerDTO(-1, 'servers', 'servers');
        }
        $raidBossName = BotHelper::getAnswerTYpe($text);
        $serverName = BotHelper::getServerName($text);
        $serverId = App::getInstance()->getConfig()->getServerId($serverName);
        return new AnswerDTO($serverId, $serverName, $raidBossName);
    }

    /**
     * @param string $serverName
     *
     * @return Keyboard
     */
    public function getKeyboard(string $serverName): Keyboard
    {
        switch ($serverName) {
            case "x3":
                $keyboard = new Keyboard(...BotHelper::getKeyboardX3());
                break;
            case "x5":
                $keyboard = new Keyboard(...BotHelper::getKeyboardX5());
                break;
            case "x7":
                $keyboard = new Keyboard(...BotHelper::getKeyboardX7());
                break;
            default:
                $keyboard = new Keyboard(...BotHelper::getKeyboardServers());
        }
        return $keyboard;
    }
}
