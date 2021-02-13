<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

class AnswerDTO
{
    /**
     * @var int
     */
    private int $serverId;

    /**
     * @var string
     */
    private string $serverName;

    /**
     * @var string
     */
    private string $type;

    /**
     * RaidDTO constructor.
     *
     * @param int    $serverId
     * @param string $serverName
     * @param string $type
     */
    public function __construct(int $serverId, string $serverName, string $type)
    {
        $this->serverId = $serverId;
        $this->serverName = $serverName;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getServerId(): int
    {
        return $this->serverId;
    }

    /**
     * @return string
     */
    public function getServerName(): string
    {
        return $this->serverName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
