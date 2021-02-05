<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot\Sender;

use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Repository;

class Alarm extends Sender
{
    /**
     * @param array $record
     * @param int   $mode
     */
    public function alarm(array $record, int $mode): void
    {
        $repo = Repository::getInstance();
        $result = $repo->getRaidById($record['id']);
        $message = 'Что-то пошло не так...';
        
        $recordMode = $result[0]['alarm'] ?? 0;
        if ($recordMode === $mode) {
            return;
        }
        if ($mode === 1 && $recordMode === 0) {
            $message = 'ALARM! Осталось менее 3ч респауна ' . $record['name'];
        }
        if ($mode === 2 && $recordMode === 1) {
            $message = 'ALARM! Осталось менее 1,5ч респауна ' . $record['name'];
        }
        
        $repo->update($record['id'], $mode);
        $channel = $repo->getChannel($result[0], $result[0]['server']);
        $answer = $this->sendMessage($message, $channel);
        
        Log::getInstance()->getLogger()->debug($answer);
    }
}
