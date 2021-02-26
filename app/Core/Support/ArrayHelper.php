<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Support;

class ArrayHelper
{
    /**
     * @param array $second
     * @param array $first
     *
     * @return array
     */
    public static function arrayDiff(array $second, array $first): array
    {
        $tmp = $result = [];
        foreach ($first as $item) {
            $tmp[hash('sha1', json_encode($item))] = $item;
        }
        foreach ($second as $item) {
            $hash = hash('sha1', json_encode($item));
            if (!isset($tmp[$hash])) {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * @param array $remoteBefore
     * @param int   $limit
     *
     * @return array
     */
    public static function getFormattedRaidBosses(array $remoteBefore, int $limit): array
    {
        var_export($remoteBefore);
        if (empty($remoteBefore)) {
            return [];
        }
        if (isset($remoteBefore['title'])) {
            $remoteBefore = [$remoteBefore];
        }
        return array_map(
            function ($record) {
                return [
                'title' => $record['title'],
                'description' => $record['description'],
                'timestamp' => $record['timestamp'],
                ];
            },
            array_slice($remoteBefore, 0, $limit)
        );
    }

    /**
     *
     * @param string $str
     * @param array  $raids
     *
     * @return bool
     */
    public static function contains(string $str, array $raids): bool
    {
        foreach ($raids as $raid) {
            if (stripos($str, $raid) !== false) {
                return true;
            }
        }
        return false;
    }
}
