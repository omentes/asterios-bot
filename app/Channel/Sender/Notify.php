<?php

namespace AsteriosBot\Channel\Sender;

interface Notify
{
    /**
     * @param array $raid
     * @param int   $serverId
     */
    public function notify(array $raid, int $serverId): void;
}
