<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\BadServerException;

class ListHandler
{
    /**
     * @var int
     */
    private int $chatId;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * ListHandler constructor.
     *
     * @param int             $chatId
     * @param Repository|null $repository
     */
    public function __construct(int $chatId, Repository $repository = null)
    {
        $this->chatId = $chatId;
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
    }

    /**
     * @return string
     * @throws BadServerException
     */
    public function getMessage(): string
    {
        return $this->handle();
    }

    /**
     * @return string
     * @throws BadServerException
     */
    private function handle(): string
    {
        $config = App::getInstance()->getConfig();
        $records = $this->repository->getAllNotifications($this->chatId);
        $message = "Cервер (x3, x5, x7) и РБ (cabrio, toi3, toi8, toi11) английскими буквами.\n";
        $message .= "`/add server boss` для добавления\n`/del server boss` для удаления\n`/list` посмотреть подписки\n";
        $message .= "Список ваших подписок:\n";
        foreach ($records as $record) {
            $message .= "\[" . $config->getServerName($record['server']) . ']';
            $message .= " {$record['type']}";
            $message .= $record['enabled'] == 1 ? ' включено' : ' отключено';
            $message .= "\n";
        }
        if (empty($records)) {
            return $message .= 'У вас нет подписок на РБ';
        }
        return $message;
    }
}
