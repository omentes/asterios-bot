<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

class BotHelper
{
    public const TEXT_TO_RAID = [
        '[x3] Cabrio' => 'Cabrio',
        '[x3] ToI 3' => 'Hallate',
        '[x5] Cabrio' => 'Cabrio',
        '[x5] ToI 3' => 'Hallate',
        '[x3] ToI 8' => 'Kernon',
        '[x3] ToI 11' => 'Golkonda',
        '[x5] ToI 8' => 'Kernon',
        '[x5] ToI 11' => 'Golkonda',
        '[x3] ALL SUB RB' => 'all',
        '[x5] ALL SUB RB' => 'all',
    ];

    public const TEXT_QUESTIONS = [
        '[x3] Cabrio',
        '[x3] ToI 3',
        '[x5] Cabrio',
        '[x5] ToI 3',
        '[x3] ToI 8',
        '[x3] ToI 11',
        '[x5] ToI 8',
        '[x5] ToI 11',
        '[x3] ALL SUB RB',
        '[x5] ALL SUB RB',
    ];

    public static function getKeyboard(): array
    {
        return [
            ['[x3] Cabrio', '[x3] ToI 3', '[x5] Cabrio', '[x5] ToI 3', ],
            ['[x3] ToI 8', '[x3] ToI 11', '[x5] ToI 8', '[x5] ToI 11',],
            ['[x3] ALL SUB RB', '[x5] ALL SUB RB'],
        ];
    }

    /**
     * @param string $text
     *
     * @return string
     */
    public static function getRaidName(string $text): string
    {
        return self::TEXT_TO_RAID[$text];
    }
}
