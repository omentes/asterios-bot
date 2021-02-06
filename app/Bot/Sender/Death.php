<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot\Sender;

use AsteriosBot\Core\Connection\Repository;
use DateTime;

class Death extends Sender implements Notify
{
    /**
     * @param array $raid
     * @param int   $serverId
     */
    public function notify(array $raid, int $serverId): void
    {
        $date = $this->getDateTime($raid['timestamp']);
        try {
            $this->repository->createRaidDeath($serverId, $raid);
            $channel = $this->repository->getChannel($raid, $serverId);
            [$timeUp, $timeDown] = $this->getTimeUpAndDown($this->repository, $raid['timestamp']);
            $rightNow = $this->getNowDateTime();
            $text = $this->getDeathRaidMessageText($raid['description'], $date, $timeUp, $timeDown, $rightNow);
    
            $result = $this->sendMessage($text, $channel);
        } catch (\Throwable $e) {
            $result = $e->getMessage();
        }
        $this->logger->debug($result);
    }
    
    /**
     * @param $timestamp
     *
     * @return DateTime
     */
    private function getDateTime($timestamp): DateTime
    {
        $date = new DateTime();
        $date->setTimestamp($timestamp);
        
        return $date;
}
    
    /**
     * @return DateTime
     */
    private function getNowDateTime(): DateTime
    {
        $rightNow = new DateTime();
        $rightNow->setTimestamp(time());
        
        return $rightNow;
    }
    
    /**
     * @param Repository $repo
     * @param int        $timestamp
     *
     * @return DateTime[]
     */
    private function getTimeUpAndDown(Repository $repo, int $timestamp): array
    {
        $timeUp = new DateTime();
        $timeDown = new DateTime();
        if ($this->repository->isAllianceRB($timestamp['title'])) {
            $timeUp->setTimestamp($timestamp + 24 * 60 * 60);
            $timeDown->setTimestamp($timestamp + 48 * 60 * 60);
        } else {
            $timeUp->setTimestamp($timestamp + 18 * 60 * 60);
            $timeDown->setTimestamp($timestamp + 30 * 60 * 60);
        }
        
        return [$timeUp, $timeDown];
    }
    
    /**
     * @param DateTime $date
     * @param          $description
     * @param DateTime $timeUp
     * @param DateTime $timeDown
     * @param DateTime $rightNow
     *
     * @return string
     */
    private function getDeathRaidMessageText(
        $description,
        DateTime $date,
        DateTime $timeUp,
        DateTime $timeDown,
        DateTime $rightNow
    ): string {
        $text = $date->format('Y-m-d H:i:s') . ' ' . $description;
        $text .= "\n\nВремя респа: C " . $timeUp->format('Y-m-d H:i:s') . ' до ' . $timeDown->format('Y-m-d H:i:s');
        $text .= "\n\nДонат:\n вкачать твина по рефералке на х5 https://bit.ly/asterios-invite-link";
        $text .= "\n\nТоповый донат - 11 голды от пользователя Depsik";
        $text .= "\n\nВремя получения инфы о смерти с сайта Астериоса и публикации этого сообщения: " . $rightNow->format('Y-m-d H:i:s');
        
        return $text;
}
}
