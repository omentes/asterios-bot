<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

class RaidDTO
{
    /**
     * @var int
     */
    private int $serverId;

    /**
     * @var string
     */
    private string $name;

    /**
     * RaidDTO constructor.
     *
     * @param int    $serverId
     * @param string $name
     */
    public function __construct(int $serverId, string $name)
    {
        $this->serverId = $serverId;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }
}
