<?php
declare(strict_types = 1);

namespace AsteriosBot\Core\Support;

class ArrayHelper
{
    /**
     * @param array $second
     * @param array $first
     *
     * @return array
     */
    public static function arrayRecursiveDiff(array $second, array $first): array
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
}
