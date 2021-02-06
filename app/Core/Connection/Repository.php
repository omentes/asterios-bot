<?php
declare(strict_types = 1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Support\ServerConstants;
use Feed;
use FeedException;

class Repository extends Database
{
    /**
     * @param int $server
     * @param int $limit
     *
     * @return array
     */
    public function getDataPDOid(int $server, int $limit = 20): array
    {
        $selectStatement = $this->getConnection()->select(['id', 'title', 'description', 'timestamp'])
            ->from('new_raids')
            ->where('server', '=', $server)
            ->orderBy('timestamp', 'desc')
            ->limit($limit, 0);
        
        $stmt = $selectStatement->execute();
        return $stmt->fetchAll();
    }
    /**
     * @param int $server
     * @param int $limit
     *
     * @return array
     */
    public function getDataPDO(int $server, int $limit = 20): array
    {
        $selectStatement = $this->getConnection()->select(['title', 'description', 'timestamp'])
            ->from('new_raids')
            ->where('server', '=', $server)
            ->orderBy('timestamp', 'desc')
            ->limit($limit, 0);
    
        $stmt = $selectStatement->execute();
        return $stmt->fetchAll();
    }
    
    
    /**
     * @param array $raids
     * @return array
     */
    public function getDeadRB(array $raids)
    {
        $result = [];
        $raids = array_reverse($raids);
        
        foreach ($raids as $raid) {
            $fix = 18 * 60 * 60;
            if (!$this->isSubclassRb($raid['title'])) {
                $fix = 24 * 60 * 60;
            }
            $raid['timestamp'] = time() - $raid['timestamp'] - $fix;
            $raid['name'] = explode(' was', $raid['title'])[0] ?? '';
            $result[md5($raid['title'])] = $raid;
        }
        return $result;
    }
    
    
    /**
     * @param string $text
     *
     * @return bool
     */
    public function isSubclassRb(string $text): bool
    {
        return $this->contains($text, [
            'Cabrio',
            'Hallate',
            'Kernon',
            'Golkonda',
        ]);
    }
    
    /**
     * @param string $text
     *
     * @return bool
     */
    public function isAllianceRB(string $text): bool
    {
        return $this->contains($text, [
            'Ketra',
            'Varka',
        ]);
    }
    
    /**
     *
     * @param string $str
     * @param array  $raids
     *
     * @return bool
     */
    public function contains(string $str, array $raids): bool
    {
        foreach ($raids as $raid) {
            if (stripos($str, $raid) !== false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * @param int    $time
     * @param string $name
     *
     * @return int
     */
    public function checkRespawnTime(int $time, string $name): int
    {
        $threeHours = ServerConstants::STATE_3H_SUB_RB;
        $oneAndHalfHour = ServerConstants::STATE_90M_SUB_RB;
        if ($this->isAllianceRB($name)) {
            $threeHours = ServerConstants::STATE_3H_ALLIANCE_RB ;
            $oneAndHalfHour = ServerConstants::STATE_90M_ALLIANCE_RB;
        }
        
        if ($time >= $threeHours && $time < $oneAndHalfHour) {
            return ServerConstants::ALARM_STATE_3H;
        } elseif ($time >= $oneAndHalfHour) {
            return ServerConstants::ALARM_STATE_90M;
        }
        return ServerConstants::ALARM_STATE_WAIT;
    }
    
    /**
     * @param int $id
     *
     * @return array
     */
    public function getRaidById(int $id): array
    {
        $selectStatement = $this->getConnection()->select(['id', 'title', 'server', 'alarm'])
            ->from('new_raids')
            ->where('id', '=', $id);
        $stmt = $selectStatement->execute();
        return $stmt->fetchAll();
    }
    
    
    /**
     * @param int $id
     * @param int $mode
     */
    public function updateAlarm(int $id, int $mode): void
    {
        $updateStatement = $this->getConnection()->update(['alarm' => $mode])
            ->table('new_raids')
            ->where('id', '=', $id);
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
        return $this->isSubclassRb($raid['title']) ?
            ServerConstants::CHANNELS[$server]['sub'] :
            ServerConstants::CHANNELS[$server]['key'];
    }
    
    /**
     * @param string $url
     * @param int    $limit
     *
     * @return array
     */
    public function getRSSData(string $url, int $limit = 20)
    {
        try {
            $rss = Feed::loadRss($url);
            $newData = $rss->toArray();
        } catch (FeedException $e) {
            $newData = [];
        }
        
        $remoteBefore = $newData['item'] ?? [];
        
        return array_map(function ($record) {
            return [
                'title' => $record['title'],
                'description' => $record['description'],
                'timestamp' => $record['timestamp'],
            ];
        }, array_slice($remoteBefore, 0, $limit));
    }
    
    /**
     * @param int   $server
     * @param array $raid
     *
     * @return int
     */
    public function createRaidDeath(int $server, array $raid): int
    {
        $insertStatement = $this->getConnection()->insert([
            'server',
            'title',
            'description',
            'timestamp'
        ])
            ->into('new_raids')
            ->values([
                $server,
                $raid['title'],
                $raid['description'],
                $raid['timestamp'],
            ]);
        return (int) $insertStatement->execute(false);
    }
}
