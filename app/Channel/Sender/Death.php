<?php

declare(strict_types=1);

namespace AsteriosBot\Channel\Sender;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Support\Config;
use DateTime;

class Death extends Sender implements Notify
{

    /**
     * @param array $raid
     * @param int   $serverId
     */
    public function notify(array $raid, int $serverId): void
    {
        $date = $this->getDateTime((int)$raid['timestamp']);
        try {
            $this->repository->createRaidDeath($serverId, $raid);
            if ($this->repository->isSubclass($raid['title'])) {
                $type = $this->repository->getShortRaidName($raid['title']);
                $this->repository->createEvent($serverId, $type, $raid['title']);
            }
            $channel = $this->repository->getChannel($raid, $serverId);
            [$timeUp, $timeDown] = $this->getTimeUpAndDown($raid);
            $rightNow = $this->getNowDateTime();
            $text = $this->getDeathRaidMessageText($raid['description'], $date, $timeUp, $timeDown, $rightNow);
            $this->sendMessage($text, $channel);
        } catch (\Throwable $e) {
            $result = $e->getMessage();
            $this->logger->error($result);
        }
    }

    /**
     * @param int $timestamp
     *
     * @return DateTime
     */
    private function getDateTime(int $timestamp): DateTime
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
     * @param array $raid
     *
     * @return DateTime[]
     */
    private function getTimeUpAndDown(array $raid): array
    {
        $timeUp = new DateTime();
        $timeDown = new DateTime();
        $timestamp = (int)$raid['timestamp'];
        if ($this->repository->isAlliance($raid['title'])) {
            $timeUp->setTimestamp($timestamp + Config::TWENTY_FOUR_HOURS);
            $timeDown->setTimestamp($timestamp + Config::FORTY_EIGHT_HOURS);
        } else {
            $timeUp->setTimestamp($timestamp + Config::EIGHTEEN_HOURS);
            $timeDown->setTimestamp($timestamp + Config::THIRTY_HOURS);
        }

        return [$timeUp, $timeDown];
    }

    /**
     * @param DateTime $date
     * @param $description
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
        $text .= "\n\nДонат: вкачать твина по рефералке на х5 https://bit.ly/asterios-invite-link";
        $text .= "\n\nВремя получения инфы о смерти с сайта Астериоса и публикации этого сообщения: " . $rightNow->format('Y-m-d H:i:s');
        $text .= "\n\nПодписаться на отдельного РБ или посмотреть состояние респауна в данный момент @AsteriosRBBot";

        return $text;
    }
}
