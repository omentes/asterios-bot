<?php

namespace AsteriosBot\Core\Support;

use AsteriosBot\Core\Connection\DTO\Database as DatabaseDTO;
use AsteriosBot\Core\Connection\DTO\Redis as RedisDTO;
use AsteriosBot\Core\Exception\BadServerException;

class Config
{
    public const X5 = 0;
    public const X3 = 6;
    public const X7 = 8;
    public const X5_NAME = 'x5';
    public const X3_NAME = 'x3';
    public const X7_NAME = 'x7';
    public const URL_X5 = 'https://asterios.tm/index.php?cmd=rss&serv=0&filter=keyboss&out=xml';
    public const URL_X3 = 'https://asterios.tm/index.php?cmd=rss&serv=6&filter=keyboss&out=xml';
    public const URL_X7 = 'https://asterios.tm/index.php?cmd=rss&serv=8&filter=keyboss&out=xml';
    public const CHANNELS = [
        self::X5 => [
            'sub' => '@asteriosx5rb',
            'key' => '@asteriosX5keyRB',
        ],
        self::X7 => [
            'sub' => '@asteriosx7rb',
            'key' => '@asteriosX7keyRB',
        ],
        self::X3 => [
            'sub' => '@asteriosx3rb',
            'key' => '@asteriosX3keyRB',
        ],
    ];

    public const CHANNELS_TEST = [
        self::X5 => [
            'sub' => '@who_m_1',
            'key' => '@who_m_1',
        ],
        self::X7 => [
            'sub' => '@who_m_1',
            'key' => '@who_m_1',
        ],
        self::X3 => [
            'sub' => '@who_m_1',
            'key' => '@who_m_1',
        ],
    ];

    public const URLS = [
        self::X5 => self::URL_X5,
        self::X7 => self::URL_X7,
        self::X3 => self::URL_X3,
    ];

    public const NAMES_TO_ID = [
        self::X5_NAME => self::X5,
        self::X7_NAME => self::X7,
        self::X3_NAME => self::X3,

    ];

    public const ALARM_STATE_WAIT = 0;
    public const ALARM_STATE_3H = 1;
    public const ALARM_STATE_90M = 2;

    public const STATE_3H_SUB_RB = 32400;
    public const STATE_3H_ALLIANCE_RB = 75600;
    public const STATE_90M_SUB_RB = 37800;
    public const STATE_90M_ALLIANCE_RB = 81000;

    public const SUBCLASS_RAIDS = [
        'Cabrio',
        'Hallate',
        'Kernon',
        'Golkonda',
    ];
    public const KEY_RAIDS = [
        'Ketra',
        'Varka',
        'Barakiel'
    ];

    /**
     * @param string $serverName
     *
     * @return int
     * @throws BadServerException
     */
    public function getServerId(string $serverName): int
    {
        if (!array_key_exists($serverName, self::NAMES_TO_ID)) {
            throw new BadServerException('Bad server name. Server not found!');
        }

        return self::NAMES_TO_ID[$serverName];
    }

    /**
     * @param int $server
     *
     * @return string
     * @throws BadServerException
     */
    public function getRSSUrl(int $server): string
    {
        if (!array_key_exists($server, self::URLS)) {
            throw new BadServerException('Bad server id. RSS url not found!');
        }

        return self::URLS[$server];
    }

    /**
     * @return bool
     */
    public function isTestServer(): bool
    {
        return getenv('SERVICE_ROLE') && 'test' === getenv('SERVICE_ROLE');
    }

    /**
     * @return DatabaseDTO
     */
    public function getDatabaseDTO(): DatabaseDTO
    {
        if ($this->isTestServer()) {
            return new DatabaseDTO(
                getenv('DB_HOST'),
                getenv('DB_NAME_TEST'),
                getenv('DB_USERNAME'),
                getenv('DB_PASSWORD')
            );
        }

        return new DatabaseDTO(
            getenv('DB_HOST'),
            getenv('DB_NAME'),
            getenv('DB_USERNAME'),
            getenv('DB_PASSWORD')
        );
    }

    /**
     * @return RedisDTO
     */
    public function getRedisDTO(): RedisDTO
    {
        return new RedisDTO(
            getenv('REDIS_HOST'),
            getenv('REDIS_PORT'),
            getenv('REDIS_DB')
        );
    }

    /**
     * @param int $server
     *
     * @return string
     */
    public function getSubChannel(int $server): string
    {
        return $this->getChannel($server, 'sub');
    }

    /**
     * @param int $server
     *
     * @return string
     */
    public function getKeyChannel(int $server): string
    {
        return $this->getChannel($server, 'sub');
    }

    /**
     * @param int    $server
     * @param string $type
     *
     * @return string
     */
    public function getChannel(int $server, string $type): string
    {
        $channels = $this->isTestServer() ? self::CHANNELS_TEST : self::CHANNELS;

        return $channels[$server][$type];
    }
}
