<?php

declare(strict_types=1);

namespace AsteriosBot\Channel\Sender;

class Alarm extends Sender implements Notify
{
    /**
     * @param array $raid
     * @param int   $serverId
     */
    public function notify(array $raid, int $serverId): void
    {
        $mode = $this->repository->checkRespawnTime($raid['timestamp'], $raid['name']);
        $result = $this->repository->getRaidBossById($raid['id']);
        $recordMode = (int)$result['alarm'] ?? 0;
        if ($recordMode === $mode) {
            return;
        }

        $message = $this->getMessage($mode, $raid['name']);
        $this->repository->updateAlarm($raid['id'], $mode);
        $channel = $this->repository->getChannel($result, $serverId);
        $answer = $this->sendMessage($message, $channel);

        $this->logger->debug($answer);
    }

    /**
     * @param int    $mode
     * @param string $name
     *
     * @return string
     */
    private function getMessage(int $mode, string $name): string
    {
        $message = 'Что-то пошло не так...';
        if ($mode === 1) {
            $message = 'ALARM! Начался респаун ' . $name;
        }
        if ($mode === 2) {
            $message = 'ALARM! Осталось менее 3ч респауна ' . $name;
        }
        if ($mode === 3) {
            $message = 'ALARM! Осталось менее 1,5ч респауна ' . $name;
        }

        return $message;
    }
}
