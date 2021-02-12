<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;

class Director
{
    /**
     * @var int
     */
    private int $serverId;

    /**
     * @var string
     */
    private string $raidBossName;

    /**
     * @var string
     */
    private string $serverName;
    
    /**
     * RaidDTO constructor.
     *
     * @param int    $serverId
     * @param string $serverName
     * @param string $raidBossName
     */
    public function __construct(int $serverId, string $serverName, string $raidBossName)
    {
        $this->serverId = $serverId;
        $this->serverName = $serverName;
        $this->raidBossName = $raidBossName;
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
    public function getRaidBossName(): string
    {
        return $this->raidBossName;
    }
    
    /**
     * @return string
     */
    public function getServerName(): string
    {
        return $this->serverName;
    }
}
