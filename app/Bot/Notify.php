<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\Connection\Repository;
use Longman\TelegramBot\Exception\TelegramException;
use Longman\TelegramBot\Request;

class Notify
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * Notify constructor.
     *
     * @param Repository|null $repository
     */
    public function __construct(Repository $repository = null)
    {
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
    }

    /**
     *
     * @throws TelegramException
     */
    public function handle(): void
    {
        $events = $this->repository->getAllEvents();
        foreach ($events as $event) {
            $chats = $this->repository->getChatsForEvent($event['server'], $event['type']);
            foreach ($chats as $chat) {
                $data = [
                    'chat_id' => $chat['chat_id'],
                    'text' => $event['message'],
                ];
                Request::sendMessage($data);
            }
            $this->repository->updateEvents($event['id']);
        }
    }
}
