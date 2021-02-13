<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;

class BotHelper
{
    public const RAID_NAMES = [
        'Shilen\'s Messenger Cabrio',
        'Death Lord Hallate',
        'Kernon',
        'Longhorn Golkonda'
    ];
    
    public const AVAILABLE_INPUTS = [
        '[x3]',
        '[x5]',
        '[x7]',
        '[x3] Cabrio',
        '[x3] ToI 3 Hallate',
        '[x3] ToI 8 Kernon',
        '[x3] ToI 11 Golkonda',
        '[x3] Все РБ',
        '[x5] Cabrio',
        '[x5] ToI 3 Hallate',
        '[x5] ToI 8 Kernon',
        '[x5] ToI 11 Golkonda',
        '[x5] Все РБ',
        '[x7] Cabrio',
        '[x7] ToI 3 Hallate',
        '[x7] ToI 8 Kernon',
        '[x7] ToI 11 Golkonda',
        '[x7] Все РБ',
    ];
    
    public const FLOORS = [
        '[x3]' => -1,
        '[x5]' => -1,
        '[x7]' => -1,
        'all' => -1,
        'Shilen\'s Messenger Cabrio' => -1,
        'Death Lord Hallate' => 3,
        'Kernon' => 8,
        'Longhorn Golkonda' => 11,
    ];

    public const INPUT_TO_TYPE = [
        'Другой сервер' => 'servers',
        '[x3]' => 'all',
        '[x3] Cabrio' => 'Shilen\'s Messenger Cabrio',
        '[x3] ToI 3 Hallate' => 'Death Lord Hallate',
        '[x3] ToI 8 Kernon' => 'Kernon',
        '[x3] ToI 11 Golkonda' => 'Longhorn Golkonda',
        '[x3] Все РБ' => 'all',
        '[x5]' => 'all',
        '[x5] Cabrio' => 'Shilen\'s Messenger Cabrio',
        '[x5] ToI 3 Hallate' => 'Death Lord Hallate',
        '[x5] ToI 8 Kernon' => 'Kernon',
        '[x5] ToI 11 Golkonda' => 'Longhorn Golkonda',
        '[x5] Все РБ' => 'all',
        '[x7]' => 'all',
        '[x7] Cabrio' => 'Shilen\'s Messenger Cabrio',
        '[x7] ToI 3 Hallate' => 'Death Lord Hallate',
        '[x7] ToI 8 Kernon' => 'Kernon',
        '[x7] ToI 11 Golkonda' => 'Longhorn Golkonda',
        '[x7] Все РБ' => 'all',
    ];

    public const INPUT_TO_SERVER = [
        'Другой сервер' => 'servers',
        '[x3]' => 'x3',
        '[x3] Cabrio' => 'x3',
        '[x3] ToI 3 Hallate' => 'x3',
        '[x3] ToI 8 Kernon' => 'x3',
        '[x3] ToI 11 Golkonda' => 'x3',
        '[x3] Все РБ' => 'x3',
        '[x5]' => 'x5',
        '[x5] Cabrio' => 'x5',
        '[x5] ToI 3 Hallate' => 'x5',
        '[x5] ToI 8 Kernon' => 'x5',
        '[x5] ToI 11 Golkonda' => 'x5',
        '[x5] Все РБ' => 'x5',
        '[x7]' => 'x7',
        '[x7] Cabrio' => 'x7',
        '[x7] ToI 3 Hallate' => 'x7',
        '[x7] ToI 8 Kernon' => 'x7',
        '[x7] ToI 11 Golkonda' => 'x7',
        '[x7] Все РБ' => 'x7',
    ];

    public static function getKeyboard(): array
    {
        return [
            ['[x3] Cabrio', '[x3] ToI 3 Hallate', '[x5] Cabrio', '[x5] ToI 3 Hallate',],
            ['[x3] ToI 8 Kernon', '[x3] ToI 11 Golkonda', '[x5] ToI 8 Kernon', '[x5] ToI 11 Golkonda',],
            ['[x3] Все РБ', '[x5] Все РБ'],
        ];
    }

    /**
     * @return array
     */
    public static function getKeyboardServers(): array
    {
        $servers = App::getInstance()->getConfig()->getEnableServers();
        $buttons = [];
        foreach ($servers as $server) {
            $buttons = array_merge($buttons, ["[$server]"]);
        }
        return [
            $buttons,
        ];
    }

    /**
     * @return array
     */
    public static function getKeyboardX5(): array
    {
        return [
            ['[x5] Cabrio', '[x5] ToI 3 Hallate',],
            ['[x5] ToI 8 Kernon', '[x5] ToI 11 Golkonda',],
            ['Другой сервер', '[x5] Все РБ'],
        ];
    }

    /**
     * @return array
     */
    public static function getKeyboardX3(): array
    {
        return [
            ['[x3] Cabrio', '[x3] ToI 3 Hallate',],
            ['[x3] ToI 8 Kernon', '[x3] ToI 11 Golkonda',],
            ['Другой сервер', '[x3] Все РБ'],
        ];
    }

    /**
     * @return array
     */
    public static function getKeyboardX7(): array
    {
        return [
            ['[x7] Cabrio', '[x7] ToI 3 Hallate',],
            ['[x7] ToI 8 Kernon', '[x7] ToI 11 Golkonda',],
            ['Другой сервер', '[x7] Все РБ'],
        ];
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function getAnswerTYpe(string $text): string
    {
        return self::INPUT_TO_TYPE[$text];
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function getServerName(string $text): string
    {
        return self::INPUT_TO_SERVER[$text];
    }
    
    /**
     * @param string $message
     *
     * @return int
     */
    public static function getFloor(string $message): int
    {
        return self::FLOORS[$message];
    }
}
