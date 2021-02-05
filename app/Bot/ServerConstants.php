<?php

namespace AsteriosBot\Bot;

class ServerConstants
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
    
    
    
}