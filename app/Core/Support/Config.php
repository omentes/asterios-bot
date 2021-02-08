<?php

namespace AsteriosBot\Core\Support;

use AsteriosBot\Core\Connection\DTO\Database as DatabaseDTO;
use AsteriosBot\Core\Connection\DTO\Redis as RedisDTO;
use AsteriosBot\Core\Exception\BadServerException;
use AsteriosBot\Core\Exception\EnvironmentException;

class Config
{
    public const X3 = 6;
    public const X5 = 0;
    public const X7 = 8;
    public const X3_NAME = 'x3';
    public const X5_NAME = 'x5';
    public const X7_NAME = 'x7';
    public const URL_X3 = 'https://asterios.tm/index.php?cmd=rss&serv=6&filter=keyboss&out=xml';
    public const URL_X5 = 'https://asterios.tm/index.php?cmd=rss&serv=0&filter=keyboss&out=xml';
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
        self::X3 => self::URL_X3,
        self::X5 => self::URL_X5,
        self::X7 => self::URL_X7,
    ];

    public const NAMES_TO_ID = [
        self::X3_NAME => self::X3,
        self::X5_NAME => self::X5,
        self::X7_NAME => self::X7,

    ];

    public const EIGHTEEN_HOURS = 18 * 60 * 60;
    public const THIRTY_HOURS = 30 * 60 * 60;
    public const TWENTY_FOUR_HOURS = 24 * 60 * 60;
    public const FORTY_EIGHT_HOURS = 48 * 60 * 60;

    public const ALARM_STATE_WAIT = 0;
    public const ALARM_STATE_START_RESPAWN = 1;
    public const ALARM_STATE_3H = 2;
    public const ALARM_STATE_90M = 3;

    public const STATE_3H_SUB_RB = 97200;
    public const STATE_3H_ALLIANCE_RB = 162000;
    public const STATE_90M_SUB_RB = 102600;
    public const STATE_90M_ALLIANCE_RB = 167400;

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
    const RAIDS_NAME_TO_TITLE = [
        'Death Lord Hallate',
        'Flame of Splendor Barakiel',
        'Kernon',
        'Ketra\'s Chief Brakki',
        'Ketra\'s Commander Tayr',
        'Ketra\'s Hero Hekaton',
        'Longhorn Golkonda',
        'Shilen\'s Messenger Cabrio',
        'Varka\'s Chief Horus',
        'Varka\'s Commander Mos',
        'Varka\'s Hero Shadith',

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
        return $this->getChannel($server, 'key');
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

    /**
     * @return bool
     */
    public function isSilentMode(): bool
    {
        return getenv('SILENT_MODE') && 'true' === getenv('SILENT_MODE');
    }

    /**
     * @return bool
     */
    public function isFillerMode(): bool
    {
        return getenv('FILLER_MODE') && 'true' === getenv('FILLER_MODE');
    }

    /**
     * @return string
     * @throws EnvironmentException
     */
    public function getTelegramToken(): string
    {
        if (getenv('TG_API') === false) {
            throw new EnvironmentException('TG_API not found in .env');
        }

        return getenv('TG_API');
    }
    /**
     * @return string
     * @throws EnvironmentException
     */
    public function getTelegramBotName(): string
    {
        if (getenv('TG_NAME') === false) {
            throw new EnvironmentException('TG_NAME not found in .env');
        }

        return getenv('TG_NAME');
    }

    /**
     * @return int
     * @throws EnvironmentException
     */
    public function getTelegramAdminId(): int
    {
        if (getenv('TG_ADMIN_ID') === false) {
            throw new EnvironmentException('TG_ADMIN_ID not found in .env');
        }

        return intval(getenv('TG_ADMIN_ID'));
    }
}
