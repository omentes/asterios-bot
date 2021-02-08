<?php

namespace unit;

use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\Config;
use Codeception\Test\Unit;
use UnitTester;

class RepositoryTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;

    /**
     * @dataProvider arrayDiffProvider
     *
     * @param array $example
     */
    public function testCheckRespawnTime(array $example)
    {
        $repository = Repository::getInstance();
        $actual = $repository->checkRespawnTime($example['timestamp'], $example['name']);
        $this->assertEquals($example['expected'], $actual);
    }

    /**
     * @return array
     */
    public static function arrayDiffProvider(): array
    {
        return [
            [['timestamp' => 0, 'name' => 'Kernon', 'expected' => 0,]],
            [['timestamp' => Config::EIGHTEEN_HOURS, 'name' => 'Kernon', 'expected' => 1,]],
            [['timestamp' => Config::STATE_3H_SUB_RB, 'name' => 'Kernon', 'expected' => 2,]],
            [['timestamp' => Config::STATE_90M_SUB_RB, 'name' => 'Kernon', 'expected' => 3,]],
            [['timestamp' => 0, 'name' => 'Ketra', 'expected' => 0,]],
            [['timestamp' => Config::TWENTY_FOUR_HOURS, 'name' => 'Ketra', 'expected' => 1,]],
            [['timestamp' => Config::STATE_3H_ALLIANCE_RB, 'name' => 'Ketra', 'expected' => 2,]],
            [['timestamp' => Config::STATE_90M_ALLIANCE_RB, 'name' => 'Ketra', 'expected' => 3,]],
        ];
    }
}
