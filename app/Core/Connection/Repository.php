<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Exception\BadRaidException;
use AsteriosBot\Core\Support\ArrayHelper;
use AsteriosBot\Core\Support\Config;
use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Grouping;
use FaaPz\PDO\Clause\Limit;
use Feed;
use FeedException;

class Repository extends Database
{
    /**
     * @param array $columns
     * @param int   $server
     * @param int   $limit
     *
     * @return array
     */
    public function selectRaidBossesByServer(array $columns, int $server, int $limit = 40): array
    {
        if ($this->config->isFillerMode()) {
            $limit = 100;
        }

        $selectStatement = $this->getConnection()->select($columns)
            ->from('new_raids')
            ->where(new Conditional('server', '=', $server))
            ->orderBy('timestamp', 'desc')
            ->limit(new Limit($limit));

        $stmt = $selectStatement->execute();
        return $stmt->fetchAll();
    }

    /**
     * @param int $server
     * @param int $limit
     *
     * @return array
     */
    public function getDeadRaidBossesWithId(int $server, int $limit = 40): array
    {
        return $this->selectRaidBossesByServer(['id', 'title', 'description', 'timestamp'], $server, $limit);
    }

    /**
     * @param int $server
     * @param int $limit
     *
     * @return array
     */
    public function getDeadRaidBosses(int $server, int $limit = 40): array
    {
        return $this->selectRaidBossesByServer(['title', 'description', 'timestamp'], $server, $limit);
    }

    /**
     * @param  array $raids
     * @return array
     */
    public function getRaidBossesWithRespawnTime(array $raids): array
    {
        $result = [];
        $raids = array_reverse($raids);
        foreach ($raids as $raid) {
            if ($this->isAlliance($raid['title'])) {
            }
            $raid['timestamp'] = time() - $raid['timestamp'];
            $raid['name'] = $this->getRaidNameByTitle($raid['title']);
            $result[md5($raid['title'])] = $raid;
        }
        return $result;
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public function isSubclass(string $text): bool
    {
        return ArrayHelper::contains($text, Config::SUBCLASS_RAIDS);
    }

    /**
     * @param string $text
     *
     * @return bool
     */
    public function isAlliance(string $text): bool
    {
        return ArrayHelper::contains($text, Config::KEY_RAIDS);
    }

    /**
     * @param int    $time
     * @param string $name
     *
     * @return int
     */
    public function checkRespawnTime(int $time, string $name): int
    {
        $threeHours = Config::STATE_3H_SUB_RB;
        $oneAndHalfHour = Config::STATE_90M_SUB_RB;
        $start = Config::EIGHTEEN_HOURS;
        if ($this->isAlliance($name)) {
            $threeHours = Config::STATE_3H_ALLIANCE_RB ;
            $oneAndHalfHour = Config::STATE_90M_ALLIANCE_RB;
            $start = Config::TWENTY_FOUR_HOURS;
        }

        if ($time >= $threeHours && $time < $oneAndHalfHour) {
            return Config::ALARM_STATE_3H;
        } elseif ($time >= $oneAndHalfHour) {
            return Config::ALARM_STATE_90M;
        } else if ($time >= $start) {
            return Config::ALARM_STATE_START_RESPAWN;
        }
        return Config::ALARM_STATE_WAIT;
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function getRaidBossById(int $id): array
    {
        $selectStatement = $this->getConnection()->select(['id', 'title', 'server', 'alarm'])
            ->from('new_raids')
            ->where(new Conditional('id', '=', $id));
        $stmt = $selectStatement->execute();
        return $stmt->fetchAll()[0] ?? [];
    }


    /**
     * @param int $id
     * @param int $mode
     */
    public function updateAlarm(int $id, int $mode): void
    {
        $updateStatement = $this->getConnection()->update(['alarm' => $mode])
            ->table('new_raids')
            ->where(new Conditional('id', '=', $id));
        $affectedRows = $updateStatement->execute();
    }

    /**
     * @param array $raid
     * @param int   $server
     *
     * @return string
     */
    public function getChannel(array $raid, int $server): string
    {
        return $this->isSubclass($raid['title']) ?
            $this->config->getSubChannel($server) :
            $this->config->getKeyChannel($server);
    }

    /**
     * @param string $url
     * @param int    $limit
     *
     * @return array
     */
    public function getRSSFeedByUrl(string $url, int $limit = 20): array
    {
        if ($this->config->isFillerMode()) {
            $limit = 100;
        }

        try {
            $rss = Feed::loadRss($url);
            $newData = $rss->toArray();
        } catch (FeedException $e) {
            $newData = [];
        }

        $remoteBefore = $newData['item'] ?? [];

        return ArrayHelper::getFormattedRaidBosses($remoteBefore, $limit);
    }

    /**
     * @param int   $server
     * @param array $raid
     */
    public function createRaidDeath(int $server, array $raid): void
    {
        $insertStatement = $this->getConnection()->insert(
            [
            'server' => $server,
            'title' => $raid['title'],
            'description' => $raid['description'],
            'timestamp' => $raid['timestamp'],
            ]
        )->into('new_raids');
        $insertStatement->execute();
    }

    /**
     * @param string $name
     * @param int    $serverId
     *
     * @return array
     */
    public function getLastRaidLikeName(string $name, int $serverId): array
    {
        $selectStatement = $this->getConnection()->select(['title', 'description', 'timestamp'])
            ->from('new_raids')
            ->where(
                new Grouping(
                    "AND",
                    new Conditional('server', '=', $serverId),
                    new Conditional('title', 'LIKE', "%$name%")
                )
            )
            ->orderBy('timestamp', 'desc')
            ->limit(new Limit(1));
        $stmt = $selectStatement->execute();
        return $stmt->fetchAll()[0];
    }

    /**
     * @param string $title
     *
     * @return string
     */
    public function getRaidNameByTitle(string $title): string
    {
        foreach (Config::RAIDS_NAME_TO_TITLE as $name) {
            if (stripos($title, $name) !== false) {
                return $name;
            }
        }

        throw new BadRaidException('Raid name not found!');
    }
}
