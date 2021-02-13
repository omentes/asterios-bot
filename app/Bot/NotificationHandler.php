<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\BadRaidException;

class NotificationHandler
{
    /**
     * @var int
     */
    private int $chatId;

    /**
     * @var int
     */
    private int $serverId;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var bool
     */
    private bool $enabled;

    /**
     * NotificationDTO constructor.
     *
     * @param int             $chatId
     * @param string          $command
     * @param bool            $enabled
     * @param Repository|null $repository
     */
    public function __construct(int $chatId, string $command, bool $enabled, Repository $repository = null)
    {
        $this->chatId = $chatId;
        $config = explode(' ', $command);
        try {
            $this->serverId = App::getInstance()->getConfig()->getServerId($config[0]);
            $this->type = $config[1] ?? '';
            $this->validateType();
        } catch (\Throwable $e) {
            $this->serverId = -1;
            $this->type = '';
        }
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
        $this->enabled = $enabled;
    }

    public function getMessage(): string
    {
        return $this->handle();
    }

    private function handle(): string
    {
        if ($this->serverId < 0 || empty($this->type)) {
            return "Ошибка в запросе! Команда должна выглядеть примерно так:
`/add server boss` для добавления
`/del server boss` для удаления
`/list` посмотреть подписки
Сначала пишем сервер (x3, x5, x7), потом одного из РБ (cabrio, toi3, toi8, toi11). Все английскими буквами.";
        }

        $this->repository->createOrUpdateNotification($this->chatId, $this->serverId, $this->type, $this->enabled);
        return "Сохранено. Проверить подписки: /list";
    }

    /**
     * @throws BadRaidException
     */
    private function validateType()
    {
        if (!in_array($this->type, ['cabrio', 'toi3', 'toi8', 'toi11'])) {
            throw new BadRaidException('Boss not found');
        }
    }
}
