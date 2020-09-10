<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";

$manager = new AsteriosBotManager();


//\Prometheus\Storage\Redis::setDefaultOptions(
//    [
//        'host' => '127.0.0.1',
//        'port' => 6379,
//        'password' => null,
//        'timeout' => 0.1, // in seconds
//        'read_timeout' => '10', // in seconds
//        'persistent_connections' => false
//    ]
//);
//
//$registry = \Prometheus\CollectorRegistry::getDefault();

//$counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_test', 'it increases');
//$counter->incBy(1, []);


$pdo = $manager->getPDO();
$raids = $manager->getRaidsLikeThis($pdo, 'Cabrio', $manager::X7);

$old = new DateTime();
$results = [];
foreach ($raids as $index => $raid) {
    if ($index) {
        $time = new DateTime();
        $time->setTimestamp($raid['timestamp']);
        $diff = $old->diff($time);
        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);
        $minutes = $diff->i;
        echo "{$hours}:{$minutes}\n";
        if (!isset($results[$hours])) {
            $results[$hours] = 1;
        } else {
            $results[$hours]++;
        }
    }
    $old->setTimestamp($raid['timestamp']);
}

ksort ($results);

foreach ($results as $index => $result) {
    echo "{$index}\t";
    foreach (range(0, $result) as $r) {
        echo "x";
    }
    echo "\n";
}
echo "All: " . count($raids) . "\n";
pp($results);



//$counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_test', 'it increases');
//$counter->incBy(1, []);


$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, 9);
$remote = get_test(); //$manager->getRSSData($manager::URL_X7);
$newRaids =    arrayRecursiveDiff($remote, $local);
pp($remote);
//echo count($newRaids) . ' ';
//foreach ($newRaids as $raid) {
//    $manager->trySend($pdo, $raid, $manager::X5);
//}

function get_test(){
    return array (
        0 =>
            array (
                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 8. Last hit was dealt by Ganne from clan AncientRebels.',
                'timestamp' => '1599220621',
            ),
//        1 =>
//            array (
//                'title' => 'Boss Longhorn Golkonda was killed',
//                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 21. Last hit was dealt by BaseDance.',
//                'timestamp' => '1599206643',
//            ),
//        2 =>
//            array (
//                'title' => 'Boss Kernon was killed',
//                'description' => 'Boss Kernon was killed. The number of attackers: 15. Last hit was dealt by LaCringe from clan ЛюдиХээ.',
//                'timestamp' => '1599206312',
//            ),
//        3 =>
//            array (
//                'title' => 'Boss Varka\'s Hero Shadith was killed',
//                'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 5. Last hit was dealt by Ganne from clan AncientRebels.',
//                'timestamp' => '1599202260',
//            ),
//        4 =>
//            array (
//                'title' => 'Boss Ketra\'s Chief Brakki was killed',
//                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by МрВольф from clan Lionss.',
//                'timestamp' => '1599190211',
//            ),
//        5 =>
//            array (
//                'title' => 'Boss Death Lord Hallate was killed',
//                'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 3. Last hit was dealt by silverstone.',
//                'timestamp' => '1599180833',
//            ),
//        6 =>
//            array (
//                'title' => 'Boss Varka\'s Chief Horus was killed',
//                'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by МрВольф from clan Lionss.',
//                'timestamp' => '1599179910',
//            ),
//        7 =>
//            array (
//                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
//                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 14. Last hit was dealt by ХОТЕЛддАвышлоЭТО from clan Скифы.',
//                'timestamp' => '1599152669',
//            ),
//        8 =>
//            array (
//                'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by lRaid from clan асдей.',
//                'timestamp' => '1599149573',
//            ),
//        9 =>
//            array (
//                'title' => 'Boss Kernon was killed',
//                'description' => 'Boss Kernon was killed. The number of attackers: 7. Last hit was dealt by ПотныйВоин.',
//                'timestamp' => '1599139696',
//            ),
//        10 =>
//            array (
//                'title' => 'Boss Varka\'s Commander Mos was killed',
//                'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 1. Last hit was dealt by ЯблокоЗеленое from clan WithNoName.',
//                'timestamp' => '1599139582',
//            ),
//        11 =>
//            array (
//                'title' => 'Boss Ketra\'s Commander Tayr was killed',
//                'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 2. Last hit was dealt by GangstaBoSS from clan Крутой.',
//                'timestamp' => '1599117989',
//            ),
//        12 =>
//            array (
//                'title' => 'Boss Death Lord Hallate was killed',
//                'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 13. Last hit was dealt by KiBOrc.',
//                'timestamp' => '1599113727',
//            ),
//        13 =>
//            array (
//                'title' => 'Boss Longhorn Golkonda was killed',
//                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by Elley.',
//                'timestamp' => '1599111091',
//            ),
//        14 =>
//            array (
//                'title' => 'Boss Ketra\'s Hero Hekaton was killed',
//                'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Швондер from clan K1NGS.',
//                'timestamp' => '1599101086',
//            ),
//        15 =>
//            array (
//                'title' => 'Boss Varka\'s Hero Shadith was killed',
//                'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 5. Last hit was dealt by BaraD from clan traveler.',
//                'timestamp' => '1599083057',
//            ),
//        16 =>
//            array (
//                'title' => 'Boss Flame of Splendor Barakiel was killed',
//                'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 4. Last hit was dealt by LINDWIOR.',
//                'timestamp' => '1599065377',
//            ),
//        17 =>
//            array (
//                'title' => 'Boss Kernon was killed',
//                'description' => 'Boss Kernon was killed. The number of attackers: 18. Last hit was dealt by БогДискотеки.',
//                'timestamp' => '1599050657',
//            ),
//        18 =>
//            array (
//                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
//                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 13. Last hit was dealt by KYM0BKA from clan СтаяБомжей.',
//                'timestamp' => '1599048532',
//            ),
//        19 =>
//            array (
//                'title' => 'Boss Ketra\'s Chief Brakki was killed',
//                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by OverReAction from clan BirthdayMassacre.',
//                'timestamp' => '1599038791',
//            ),
    );

}
function pp($item)
{
    echo PHP_EOL;
    echo 'pp' . PHP_EOL;
    var_export($item);
    echo PHP_EOL;
    die();
}
function arrayRecursiveDiff($aArray1, $aArray2) {
    $aReturn = array();

    foreach ($aArray1 as $mKey => $mValue) {
        if (array_key_exists($mKey, $aArray2)) {
            if (is_array($mValue)) {
                $aRecursiveDiff = arrayRecursiveDiff($mValue, $aArray2[$mKey]);
                if (count($aRecursiveDiff)) { $aReturn[$mKey] = $aRecursiveDiff; }
            } else {
                if ($mValue != $aArray2[$mKey]) {
                    $aReturn[$mKey] = $mValue;
                }
            }
        } else {
            $aReturn[$mKey] = $mValue;
        }
    }
    return $aReturn;
}

/**
 * * * * * * php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1
 * * * * * ( sleep 7 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 15 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 23 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 30 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 37 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 45 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 53 ; php /home/ubuntu/asterios-bot/_bot.php >> /home/ubuntu/asterios.bot.log 2>&1 )

 * * * * * * php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1
 * * * * * ( sleep 7 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 15 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 23 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 30 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 37 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 45 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 * * * * * ( sleep 53 ; php /home/ubuntu/asterios-bot/_botx7.php >> /home/ubuntu/asterios.bot.log 2>&1 )
 */
