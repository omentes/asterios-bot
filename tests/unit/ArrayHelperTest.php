<?php

namespace unit;

use AsteriosBot\Core\Support\ArrayHelper;
use Codeception\Test\Unit;

class ArrayHelperTest extends Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @dataProvider arrayDiffProvider
     *
     * @param array $example
     */
    public function testArrayDiffHelper(array $example)
    {
        $actual = ArrayHelper::arrayDiff($example['remote'], $example['local']);
        $this->assertEquals($example['expected'], $actual);
    }

    /**
     * @return array
     */
    public static function arrayDiffProvider(): array
    {
        return [
            [['remote' => [
                0 =>
                    [
                        'title' => 'Boss Varka\'s Hero Shadith was killed',
                        'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by 66 from clan CORSAR.',
                        'timestamp' => '1612381895',
                    ],
                1 =>
                    [
                        'title' => 'Boss Flame of Splendor Barakiel was killed',
                        'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by handjobxxx.',
                        'timestamp' => '1612369858',
                    ],
                2 =>
                    [
                        'title' => 'Boss Kernon was killed',
                        'description' => 'Boss Kernon was killed. The number of attackers: 47. Last hit was dealt by ххСАДИСТх.',
                        'timestamp' => '1612347946',
                    ],
                3 =>
                    [
                        'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                        'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 15. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                        'timestamp' => '1612341348',
                    ],
                4 =>
                    [
                        'title' => 'Boss Death Lord Hallate was killed',
                        'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 11. Last hit was dealt by MPslivkA from clan BloodySaviors.',
                        'timestamp' => '1612334916',
                    ],
                5 =>
                    [
                        'title' => 'Boss Longhorn Golkonda was killed',
                        'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 9. Last hit was dealt by R0CKeR from clan DiabloZ.',
                        'timestamp' => '1612329014',
                    ],
                6 =>
                    [
                        'title' => 'Boss Varka\'s Chief Horus was killed',
                        'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                        'timestamp' => '1612325523',
                    ],
                7 =>
                    [
                        'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                        'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                        'timestamp' => '1612325366',
                    ],
                8 =>
                    [
                        'title' => 'Boss Ketra\'s Chief Brakki was killed',
                        'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by Tuc0Salamanca from clan PollosHermanos.',
                        'timestamp' => '1612315837',
                    ],
                9 =>
                    [
                        'title' => 'Boss Varka\'s Commander Mos was killed',
                        'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 2. Last hit was dealt by БликСолнца from clan Хранители.',
                        'timestamp' => '1612310103',
                    ],
                10 =>
                    [
                        'title' => 'Boss Varka\'s Hero Shadith was killed',
                        'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                        'timestamp' => '1612283444',
                    ],
                11 =>
                    [
                        'title' => 'Boss Flame of Splendor Barakiel was killed',
                        'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 2. Last hit was dealt by GoddessOfSin from clan Nyamki.',
                        'timestamp' => '1612259714',
                    ],
                12 =>
                    [
                        'title' => 'Boss Longhorn Golkonda was killed',
                        'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by Buton from clan ObsidianUnion.',
                        'timestamp' => '1612259274',
                    ],
                13 =>
                    [
                        'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                        'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 25. Last hit was dealt by KotoVod149 from clan Federation.',
                        'timestamp' => '1612258394',
                    ],
                14 =>
                    [
                        'title' => 'Boss Ketra\'s Commander Tayr was killed',
                        'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 2. Last hit was dealt by BoobleGum from clan Импульсивные.',
                        'timestamp' => '1612255232',
                    ],
                15 =>
                    [
                        'title' => 'Boss Death Lord Hallate was killed',
                        'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 13. Last hit was dealt by Xamochkin from clan Beehive.',
                        'timestamp' => '1612248784',
                    ],
                16 =>
                    [
                        'title' => 'Boss Kernon was killed',
                        'description' => 'Boss Kernon was killed. The number of attackers: 9. Last hit was dealt by Zubast1k from clan PrideOfKittens.',
                        'timestamp' => '1612241156',
                    ],
                17 =>
                    [
                        'title' => 'Boss Longhorn Golkonda was killed',
                        'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                        'timestamp' => '1612189948',
                    ],
                18 =>
                    [
                        'title' => 'Boss Ketra\'s Chief Brakki was killed',
                        'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                        'timestamp' => '1612188515',
                    ],
                19 =>
                    [
                        'title' => 'Boss Varka\'s Chief Horus was killed',
                        'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                        'timestamp' => '1612178693',
                    ],
            ],
                'local' =>   [
                    0 =>
                        [
                            'title' => 'Boss Varka\'s Hero Shadith was killed',
                            'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by 66 from clan CORSAR.',
                            'timestamp' => '1612381895',
                        ],
                    1 =>
                        [
                            'title' => 'Boss Flame of Splendor Barakiel was killed',
                            'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by handjobxxx.',
                            'timestamp' => '1612369858',
                        ],
                    2 =>
                        [
                            'title' => 'Boss Kernon was killed',
                            'description' => 'Boss Kernon was killed. The number of attackers: 47. Last hit was dealt by ххСАДИСТх.',
                            'timestamp' => '1612347946',
                        ],
                    3 =>
                        [
                            'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                            'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 15. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                            'timestamp' => '1612341348',
                        ],
                    4 =>
                        [
                            'title' => 'Boss Death Lord Hallate was killed',
                            'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 11. Last hit was dealt by MPslivkA from clan BloodySaviors.',
                            'timestamp' => '1612334916',
                        ],
                    5 =>
                        [
                            'title' => 'Boss Longhorn Golkonda was killed',
                            'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 9. Last hit was dealt by R0CKeR from clan DiabloZ.',
                            'timestamp' => '1612329014',
                        ],
                    6 =>
                        [
                            'title' => 'Boss Varka\'s Chief Horus was killed',
                            'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                            'timestamp' => '1612325523',
                        ],
                    7 =>
                        [
                            'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                            'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                            'timestamp' => '1612325366',
                        ],
                    8 =>
                        [
                            'title' => 'Boss Ketra\'s Chief Brakki was killed',
                            'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by Tuc0Salamanca from clan PollosHermanos.',
                            'timestamp' => '1612315837',
                        ],
                    9 =>
                        [
                            'title' => 'Boss Varka\'s Commander Mos was killed',
                            'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 2. Last hit was dealt by БликСолнца from clan Хранители.',
                            'timestamp' => '1612310103',
                        ],
                    10 =>
                        [
                            'title' => 'Boss Varka\'s Hero Shadith was killed',
                            'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                            'timestamp' => '1612283444',
                        ],
                    11 =>
                        [
                            'title' => 'Boss Flame of Splendor Barakiel was killed',
                            'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 2. Last hit was dealt by GoddessOfSin from clan Nyamki.',
                            'timestamp' => '1612259714',
                        ],
                    12 =>
                        [
                            'title' => 'Boss Longhorn Golkonda was killed',
                            'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by Buton from clan ObsidianUnion.',
                            'timestamp' => '1612259274',
                        ],
                    13 =>
                        [
                            'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                            'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 25. Last hit was dealt by KotoVod149 from clan Federation.',
                            'timestamp' => '1612258394',
                        ],
                    14 =>
                        [
                            'title' => 'Boss Ketra\'s Commander Tayr was killed',
                            'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 2. Last hit was dealt by BoobleGum from clan Импульсивные.',
                            'timestamp' => '1612255232',
                        ],
                    15 =>
                        [
                            'title' => 'Boss Death Lord Hallate was killed',
                            'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 13. Last hit was dealt by Xamochkin from clan Beehive.',
                            'timestamp' => '1612248784',
                        ],
                    16 =>
                        [
                            'title' => 'Boss Kernon was killed',
                            'description' => 'Boss Kernon was killed. The number of attackers: 9. Last hit was dealt by Zubast1k from clan PrideOfKittens.',
                            'timestamp' => '1612241156',
                        ],
                    17 =>
                        [
                            'title' => 'Boss Longhorn Golkonda was killed',
                            'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                            'timestamp' => '1612189948',
                        ],
                    18 =>
                        [
                            'title' => 'Boss Ketra\'s Chief Brakki was killed',
                            'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                            'timestamp' => '1612188515',
                        ],
                    19 =>
                        [
                            'title' => 'Boss Varka\'s Chief Horus was killed',
                            'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                            'timestamp' => '1612178693',
                        ],
                ], 'expected' => [],]],
            [['remote' => [
                0 =>
                    [
                        'title' => 'Boss Varka\'s Hero Shadith was killed',
                        'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by 66 from clan CORSAR.',
                        'timestamp' => '1612381895',
                    ],
                1 =>
                    [
                        'title' => 'Boss Flame of Splendor Barakiel was killed',
                        'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by handjobxxx.',
                        'timestamp' => '1612369858',
                    ],
                2 =>
                    [
                        'title' => 'Boss Kernon was killed',
                        'description' => 'Boss Kernon was killed. The number of attackers: 47. Last hit was dealt by ххСАДИСТх.',
                        'timestamp' => '1612347946',
                    ],
                3 =>
                    [
                        'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                        'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 15. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                        'timestamp' => '1612341348',
                    ],
                4 =>
                    [
                        'title' => 'Boss Death Lord Hallate was killed',
                        'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 11. Last hit was dealt by MPslivkA from clan BloodySaviors.',
                        'timestamp' => '1612334916',
                    ],
                5 =>
                    [
                        'title' => 'Boss Longhorn Golkonda was killed',
                        'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 9. Last hit was dealt by R0CKeR from clan DiabloZ.',
                        'timestamp' => '1612329014',
                    ],
                6 =>
                    [
                        'title' => 'Boss Varka\'s Chief Horus was killed',
                        'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                        'timestamp' => '1612325523',
                    ],
                7 =>
                    [
                        'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                        'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                        'timestamp' => '1612325366',
                    ],
                8 =>
                    [
                        'title' => 'Boss Ketra\'s Chief Brakki was killed',
                        'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by Tuc0Salamanca from clan PollosHermanos.',
                        'timestamp' => '1612315837',
                    ],
                9 =>
                    [
                        'title' => 'Boss Varka\'s Commander Mos was killed',
                        'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 2. Last hit was dealt by БликСолнца from clan Хранители.',
                        'timestamp' => '1612310103',
                    ],
                10 =>
                    [
                        'title' => 'Boss Varka\'s Hero Shadith was killed',
                        'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                        'timestamp' => '1612283444',
                    ],
                11 =>
                    [
                        'title' => 'Boss Flame of Splendor Barakiel was killed',
                        'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 2. Last hit was dealt by GoddessOfSin from clan Nyamki.',
                        'timestamp' => '1612259714',
                    ],
                12 =>
                    [
                        'title' => 'Boss Longhorn Golkonda was killed',
                        'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by Buton from clan ObsidianUnion.',
                        'timestamp' => '1612259274',
                    ],
                13 =>
                    [
                        'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                        'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 25. Last hit was dealt by KotoVod149 from clan Federation.',
                        'timestamp' => '1612258394',
                    ],
                14 =>
                    [
                        'title' => 'Boss Ketra\'s Commander Tayr was killed',
                        'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 2. Last hit was dealt by BoobleGum from clan Импульсивные.',
                        'timestamp' => '1612255232',
                    ],
                15 =>
                    [
                        'title' => 'Boss Death Lord Hallate was killed',
                        'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 13. Last hit was dealt by Xamochkin from clan Beehive.',
                        'timestamp' => '1612248784',
                    ],
                16 =>
                    [
                        'title' => 'Boss Kernon was killed',
                        'description' => 'Boss Kernon was killed. The number of attackers: 9. Last hit was dealt by Zubast1k from clan PrideOfKittens.',
                        'timestamp' => '1612241156',
                    ],
                17 =>
                    [
                        'title' => 'Boss Longhorn Golkonda was killed',
                        'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                        'timestamp' => '1612189948',
                    ],
                18 =>
                    [
                        'title' => 'Boss Ketra\'s Chief Brakki was killed',
                        'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                        'timestamp' => '1612188515',
                    ],
                19 =>
                    [
                        'title' => 'Boss Varka\'s Chief Horus was killed',
                        'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                        'timestamp' => '1612178693',
                    ],
            ],
                'local' =>   [],
                'expected' => [
                    0 =>
                        [
                            'title' => 'Boss Varka\'s Hero Shadith was killed',
                            'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by 66 from clan CORSAR.',
                            'timestamp' => '1612381895',
                        ],
                    1 =>
                        [
                            'title' => 'Boss Flame of Splendor Barakiel was killed',
                            'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by handjobxxx.',
                            'timestamp' => '1612369858',
                        ],
                    2 =>
                        [
                            'title' => 'Boss Kernon was killed',
                            'description' => 'Boss Kernon was killed. The number of attackers: 47. Last hit was dealt by ххСАДИСТх.',
                            'timestamp' => '1612347946',
                        ],
                    3 =>
                        [
                            'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                            'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 15. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                            'timestamp' => '1612341348',
                        ],
                    4 =>
                        [
                            'title' => 'Boss Death Lord Hallate was killed',
                            'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 11. Last hit was dealt by MPslivkA from clan BloodySaviors.',
                            'timestamp' => '1612334916',
                        ],
                    5 =>
                        [
                            'title' => 'Boss Longhorn Golkonda was killed',
                            'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 9. Last hit was dealt by R0CKeR from clan DiabloZ.',
                            'timestamp' => '1612329014',
                        ],
                    6 =>
                        [
                            'title' => 'Boss Varka\'s Chief Horus was killed',
                            'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                            'timestamp' => '1612325523',
                        ],
                    7 =>
                        [
                            'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                            'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                            'timestamp' => '1612325366',
                        ],
                    8 =>
                        [
                            'title' => 'Boss Ketra\'s Chief Brakki was killed',
                            'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by Tuc0Salamanca from clan PollosHermanos.',
                            'timestamp' => '1612315837',
                        ],
                    9 =>
                        [
                            'title' => 'Boss Varka\'s Commander Mos was killed',
                            'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 2. Last hit was dealt by БликСолнца from clan Хранители.',
                            'timestamp' => '1612310103',
                        ],
                    10 =>
                        [
                            'title' => 'Boss Varka\'s Hero Shadith was killed',
                            'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                            'timestamp' => '1612283444',
                        ],
                    11 =>
                        [
                            'title' => 'Boss Flame of Splendor Barakiel was killed',
                            'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 2. Last hit was dealt by GoddessOfSin from clan Nyamki.',
                            'timestamp' => '1612259714',
                        ],
                    12 =>
                        [
                            'title' => 'Boss Longhorn Golkonda was killed',
                            'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by Buton from clan ObsidianUnion.',
                            'timestamp' => '1612259274',
                        ],
                    13 =>
                        [
                            'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                            'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 25. Last hit was dealt by KotoVod149 from clan Federation.',
                            'timestamp' => '1612258394',
                        ],
                    14 =>
                        [
                            'title' => 'Boss Ketra\'s Commander Tayr was killed',
                            'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 2. Last hit was dealt by BoobleGum from clan Импульсивные.',
                            'timestamp' => '1612255232',
                        ],
                    15 =>
                        [
                            'title' => 'Boss Death Lord Hallate was killed',
                            'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 13. Last hit was dealt by Xamochkin from clan Beehive.',
                            'timestamp' => '1612248784',
                        ],
                    16 =>
                        [
                            'title' => 'Boss Kernon was killed',
                            'description' => 'Boss Kernon was killed. The number of attackers: 9. Last hit was dealt by Zubast1k from clan PrideOfKittens.',
                            'timestamp' => '1612241156',
                        ],
                    17 =>
                        [
                            'title' => 'Boss Longhorn Golkonda was killed',
                            'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                            'timestamp' => '1612189948',
                        ],
                    18 =>
                        [
                            'title' => 'Boss Ketra\'s Chief Brakki was killed',
                            'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                            'timestamp' => '1612188515',
                        ],
                    19 =>
                        [
                            'title' => 'Boss Varka\'s Chief Horus was killed',
                            'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                            'timestamp' => '1612178693',
                        ],
                ],]],
            [['remote' => [0 =>
                [
                    'title' => 'Boss Longhorn Golkonda was killed',
                    'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                    'timestamp' => '1612189948',
                ],
                1 =>
                    [
                        'title' => 'Boss Ketra\'s Chief Brakki was killed',
                        'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                        'timestamp' => '1612188515',
                    ],
                2 =>
                    [
                        'title' => 'Boss Varka\'s Chief Horus was killed',
                        'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                        'timestamp' => '1612178693',
                    ]], 'local' => [0 =>
                [
                    'title' => 'Boss Longhorn Golkonda was killed',
                    'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                    'timestamp' => '1612189948',
                ],
                1 =>
                    [
                        'title' => 'Boss Varka\'s Chief Horus was killed',
                        'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                        'timestamp' => '1612178693',
                    ]], 'expected' => [[
                'title' => 'Boss Ketra\'s Chief Brakki was killed',
                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                'timestamp' => '1612188515',
            ],],]],
            [['remote' => [], 'local' => [], 'expected' => [],]],
            [['remote' => [[
                'title' => 'Boss Varka\'s Chief Horus was killed',
                'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                'timestamp' => '1612178693',
            ]], 'local' => [], 'expected' => [[
                'title' => 'Boss Varka\'s Chief Horus was killed',
                'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                'timestamp' => '1612178693',
            ]],]],
        ];
    }
}
