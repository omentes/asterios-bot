<?php

namespace AsteriosBot\Bot\Sender;

interface Notify
{
    /**
     * @param array $raid
     * @param int   $serverId
     */
    public function notify(array $raid, int $serverId): void;
}
