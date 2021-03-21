<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Exception\BadServerException;
use AsteriosBot\Core\Support\Config;
use DateTime;

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


    /**
     * @param array  $raid
     * @param string $name
     * @param int    $floor
     *
     * @return string[]
     */
    public static function prepareTextForExport(array $raid, string $name, int $floor): array
    {
        $raid['timestamp'] = intval($raid['timestamp']);
        if (empty($raid)) {
            return [];
        }
        $floors = $floor > 0 ? " ({$floor} этаж)" : '';
        if (time() - $raid['timestamp'] < Config::EIGHTEEN_HOURS) {
            $respawn = new DateTime();
            $respawn->setTimestamp(Config::EIGHTEEN_HOURS + $raid['timestamp']);
            $now = new DateTime();
            $now->setTimestamp(time());
            $interval = $respawn->diff($now);
            return ["{$name}{$floors}" => "Респ начнется через " . $interval->format('%H:%I:%S')];
        }
        if (time() - $raid['timestamp'] > Config::THIRTY_HOURS) {
            return ["{$name}{$floors}" => "Уже должен стоять"];
        }

        $respawn = new DateTime();
        $respawn->setTimestamp($raid['timestamp'] + Config::EIGHTEEN_HOURS);
        $now = new DateTime();
        $now->setTimestamp(time());
        $interval = $now->diff($respawn);
        return ["{$name}{$floors}" => "Респ идет уже " . $interval->format('%H:%I:%S')];
    }

    public static function getWhiteSVGStart(): string
    {
        return <<<SVG
<svg width="420" height="160" xmlns="http://www.w3.org/2000/svg">
    <style>
svg {
  font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji;
  font-size: 14px;
  line-height: 21px;
}

#background {
  width: calc(100% - 10px);
  height: calc(100% - 10px);
  fill: white;
  stroke: rgb(151,154,157);
  stroke-width: 1px;
  rx: 6px;
  ry: 6px;
}

foreignObject {
  width: calc(100% - 10px - 32px);
  height: calc(100% - 10px - 32px);
}

table {
  width: 100%;
  border-collapse: collapse;
  table-layout: auto;
}

th {
  padding: 0.5em;
  padding-top: 0;
  text-align: left;
  font-size: 14px;
  font-weight: 600;
  color: rgb(3, 102, 214);
}
th a {
  color: rgb(3, 102, 214);
  text-decoration: none;
}

td {
  margin-bottom: 16px;
  margin-top: 8px;
  padding: 0.25em;
  font-size: 12px;
  line-height: 18px;
  color: rgb(88, 96, 105);
}

tr {
  transform: translateX(-200%);
  animation-duration: 1s;
  animation-name: slideIn;
  animation-function: ease-in-out;
  animation-fill-mode: forwards;
}

.octicon {
  fill: rgb(88, 96, 105);
  margin-right: 1ch;
  vertical-align: top;
}

@keyframes slideIn {
  to {
    transform: translateX(0);
  }
}
    </style>
    <g>
        <rect x="5" y="5" id="background" />
        <g>
            <foreignObject x="21" y="21" width="318" height="168">
                <div xmlns="http://www.w3.org/1999/xhtml">

                    <table>
                        <thead><tr style="transform: translateX(0);">
                            <th colspan="2">[:server] <a href="https://t.me/AsteriosRBbot">AsteriosRBBot</a>
                            Обновлено :datetime </th>
                        </tr></thead>
                        <tbody>
SVG;
    }

    public static function getSVGContent(): string
    {
        return <<<SVG
<tr><td><svg class="octicon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" width="16" height="16"><path fill-rule="evenodd" d="M8 .25a.75.75 0 01.673.418l1.882 3.815 4.21.612a.75.75 0 01.416 1.279l-3.046 2.97.719 4.192a.75.75 0 01-1.088.791L8 12.347l-3.766 1.98a.75.75 0 01-1.088-.79l.72-4.194L.818 6.374a.75.75 0 01.416-1.28l4.21-.611L7.327.668A.75.75 0 018 .25zm0 2.445L6.615 5.5a.75.75 0 01-.564.41l-3.097.45 2.24 2.184a.75.75 0 01.216.664l-.528 3.084 2.769-1.456a.75.75 0 01.698 0l2.77 1.456-.53-3.084a.75.75 0 01.216-.664l2.24-2.183-3.096-.45a.75.75 0 01-.564-.41L8 2.694v.001z"></path></svg>:raid</td><td>:resp</td></tr>
SVG;
    }




    /**
     *
     * @param string $text
     *
     * @return AnswerDTO
     * @throws BadServerException
     */
    public static function parseText(string $text): AnswerDTO
    {
        if (!in_array($text, BotHelper::AVAILABLE_INPUTS)) {
            return new AnswerDTO(-1, 'servers', 'servers');
        }
        $raidBossName = BotHelper::getAnswerTYpe($text);
        $serverName = BotHelper::getServerName($text);
        $serverId = App::getInstance()->getConfig()->getServerId($serverName);
        return new AnswerDTO($serverId, $serverName, $raidBossName);
    }

    public static function getSVGEnd()
    {
        return <<<SVG
                        </tbody>
                    </table>

                </div>
            </foreignObject>
        </g>
    </g>
</svg>

SVG;
    }
    
    public static function getDarkSVGStart()
    {
        return <<<SVG
<svg width="420" height="160" xmlns="http://www.w3.org/2000/svg">
    <style>
svg {
  font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji;
  font-size: 14px;
  line-height: 21px;
}

#background {
  width: calc(100% - 10px);
  height: calc(100% - 10px);
  fill: #22272e;
  stroke: rgb(151,154,157);
  stroke-width: 1px;
  rx: 6px;
  ry: 6px;
}

foreignObject {
  width: calc(100% - 10px - 32px);
  height: calc(100% - 10px - 32px);
}

table {
  width: 100%;
  border-collapse: collapse;
  table-layout: auto;
}

th {
  padding: 0.5em;
  padding-top: 0;
  text-align: left;
  font-size: 14px;
  font-weight: 600;
  color: rgb(112,169,234);
}
th a {
  color: rgb(112,169,234);
  text-decoration: none;
}

td {
  margin-bottom: 16px;
  margin-top: 8px;
  padding: 0.25em;
  font-size: 12px;
  line-height: 18px;
  color: rgb(181,191,203);
}

tr {
  transform: translateX(-200%);
  animation-duration: 1s;
  animation-name: slideIn;
  animation-function: ease-in-out;
  animation-fill-mode: forwards;
}

.octicon {
  fill: rgb(181,191,203);
  margin-right: 1ch;
  vertical-align: top;
}

@keyframes slideIn {
  to {
    transform: translateX(0);
  }
}
    </style>
    <g>
        <rect x="5" y="5" id="background" />
        <g>
            <foreignObject x="21" y="21" width="318" height="168">
                <div xmlns="http://www.w3.org/1999/xhtml">

                    <table>
                        <thead><tr style="transform: translateX(0);">
                            <th colspan="2">[:server] <a href="https://t.me/AsteriosRBbot">AsteriosRBBot</a>
                            Обновлено :datetime </th>
                        </tr></thead>
                        <tbody>
SVG;
    }
    
    public static function getHtmlStart(): string
    {
        return <<<HTML
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<style>

#background {

  background-color: #22272e;
  font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji;
  font-size: 14px;
  line-height: 21px;
  margin-top: 30px;
  width: 100%
}

th {
  padding: 0.5em;
  margin:5px;
  padding-top: 0;
  font-size: 12px;
  font-weight: 600;
  color: rgb(112,169,234);
}
table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
    margin-left: 10px;
    /*margin-right: auto;*/
    /*text-align: center;*/
    /*align-items: center;*/
}

@media (min-width: 420px) {
    .block {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        align-items: center;
        width: 420px;
        stroke-width: 1px;
        border: 2px solid rgb(151,154,157);
        border-radius: 6px;
    }
    td {
        margin-bottom: 16px;
        margin-top: 8px;
        padding-left: 4px;
        padding-top: 4px;
        font-size: 12px;
        line-height: 18px;
        color: rgb(181,191,203);
        text-align: left;
    }
    table {
    margin-top: 20px;
    width: 100%;
    border-collapse: collapse;
    table-layout: auto;
    /*margin-left: 2px;*/
    /*margin-right: auto;*/
    /*text-align: center;*/
    /*align-items: center;*/
}
}

@media (max-width: 419px) {
    .block {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        align-items: center;
        width: 90%;
        stroke-width: 1px;
        table-layout: inherit;
        border: 2px solid rgb(151,154,157);
        border-radius: 6px;
    }
    td {
        margin-bottom: 16px;
        margin-top: 8px;
        padding-left: 4px;
        padding-top: 4px;
        font-size: 10px;
        line-height: 18px;
        color: rgb(181,191,203);
        text-align: left;
    }
}
@media (max-width: 359px) {
    .block {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        align-items: center;
        width: 95%;
        stroke-width: 1px;
        table-layout: inherit;
        border: 2px solid rgb(151,154,157);
        border-radius: 6px;
    }
    td {
        margin-bottom: 16px;
        margin-top: 8px;
        padding-left: 4px;
        padding-top: 4px;
        font-size: 9px;
        line-height: 13px;
        color: rgb(181,191,203);
        text-align: left;
    }
    th {
        font-size: 10px;
          padding: 0.5em;
  margin:5px;
  padding-top: 0;
  font-weight: 600;
  color: rgb(112,169,234);
    }
}



th a {
  color: rgb(112,169,234);
  text-decoration: none;
}



tr {
  transform: translateX(-200%);
  animation-duration: 100ms;
  animation-name: slideIn;
  animation-function: ease-in-out;
  animation-fill-mode: forwards;
}

.octicon {
  fill: rgb(181,191,203);
  margin-right: 1ch;
  vertical-align: top;
}

@keyframes slideIn {
  to {
    transform: translateX(0);
  }
}

button {
  background-color: rgb(112,169,234); /* Green */
  border: none;
  color: rgb(255,255,255);
  padding: 5px 32px;
  margin: 15px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
}

</style>
</head>
<body id="background">
    <div class="block">
        <table>
            <thead>
                <tr style="transform: translateX(0);">
                    <th colspan="2">[:server] <a href="https://t.me/AsteriosRBbot">AsteriosRBBot</a> Обновлено
                    :datetime</th>
                </tr>
            </thead>
            <tbody>
HTML;
    }
    
    public static function getHtmlContent(): string
    {
        return <<<HTML
<tr><td><svg class="octicon" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" version="1.1" width="16" height="16"><path fill-rule="evenodd" d="M8 .25a.75.75 0 01.673.418l1.882 3.815 4.21.612a.75.75 0 01.416 1.279l-3.046 2.97.719 4.192a.75.75 0 01-1.088.791L8 12.347l-3.766 1.98a.75.75 0 01-1.088-.79l.72-4.194L.818 6.374a.75.75 0 01.416-1.28l4.21-.611L7.327.668A.75.75 0 018 .25zm0 2.445L6.615 5.5a.75.75 0 01-.564.41l-3.097.45 2.24 2.184a.75.75 0 01.216.664l-.528 3.084 2.769-1.456a.75.75 0 01.698 0l2.77 1.456-.53-3.084a.75.75 0 01.216-.664l2.24-2.183-3.096-.45a.75.75 0 01-.564-.41L8 2.694v.001z"></path></svg>:raid</td><td>:resp</td></tr>
HTML;
    }
    
    public static function getHtmlEnd()
    {
        return <<<SVG
            </tbody>
        </table>
        <button onClick="window.location.reload();">Refresh Page</button>
    </div>
</body>
</html>
SVG;
    }
}
