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


//$pdo = $manager->getPDO();
//$raids = $manager->getRaidsLikeThis($pdo, 'Cabrio', $manager::X7);
//
//$old = new DateTime();
//$results = [];
//foreach ($raids as $index => $raid) {
//    if ($index) {
//        $time = new DateTime();
//        $time->setTimestamp($raid['timestamp']);
//        $diff = $old->diff($time);
//        $hours = $diff->h;
//        $hours = $hours + ($diff->days*24);
//        $minutes = $diff->i;
//        echo "{$hours}:{$minutes}\n";
//        if (!isset($results[$hours])) {
//            $results[$hours] = 1;
//        } else {
//            $results[$hours]++;
//        }
//    }
//    $old->setTimestamp($raid['timestamp']);
//}
//
//ksort ($results);
//
//foreach ($results as $index => $result) {
//    echo "{$index}\t";
//    foreach (range(0, $result) as $r) {
//        echo "x";
//    }
//    echo "\n";
//}
//echo "All: " . count($raids) . "\n";
//pp($results);



//$counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_test', 'it increases');
//$counter->incBy(1, []);


$pdo = $manager->getPDO();
$local = get_test2();
$remote = get_test(); //$manager->getRSSData($manager::URL_X7);
$newRaids =    arrayRecursiveDiff($remote, $local);
pp($newRaids);
//echo count($newRaids) . ' ';
//foreach ($newRaids as $raid) {
//    $manager->trySend($pdo, $raid, $manager::X5);
//}

function get_test(){
    return array (
        0 =>
            array (
                'title' => 'Boss Varka\'s Commander Mos was killed',
                'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                'timestamp' => '1612464577',
            ),
        1 =>
            array (
                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 22. Last hit was dealt by Oxitocin from clan KuroYami.',
                'timestamp' => '1612443700',
            ),
        2 =>
            array (
                'title' => 'Boss Flame of Splendor Barakiel was killed',
                'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by ArchiMagik from clan D0GS.',
                'timestamp' => '1612441935',
            ),
        3 =>
            array (
                'title' => 'Boss Death Lord Hallate was killed',
                'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 5. Last hit was dealt by ffs200 from clan Hidden.',
                'timestamp' => '1612425535',
            ),
        4 =>
            array (
                'title' => 'Boss Longhorn Golkonda was killed',
                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 27. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                'timestamp' => '1612424325',
            ),
        5 =>
            array (
                'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                'timestamp' => '1612415698',
            ),
        6 =>
            array (
                'title' => 'Boss Kernon was killed',
                'description' => 'Boss Kernon was killed. The number of attackers: 7. Last hit was dealt by GreenHorror.',
                'timestamp' => '1612414942',
            ),
        7 =>
            array (
                'title' => 'Boss Ketra\'s Commander Tayr was killed',
                'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 1. Last hit was dealt by K1dman from clan KuroYami.',
                'timestamp' => '1612412318',
            ),
        8 =>
            array (
                'title' => 'Boss Ketra\'s Chief Brakki was killed',
                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by H0ngAM from clan AllHongs.',
                'timestamp' => '1612408796',
            ),
        9 =>
            array (
                'title' => 'Boss Varka\'s Hero Shadith was killed',
                'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by 66 from clan CORSAR.',
                'timestamp' => '1612381895',
            ),
        10 =>
            array (
                'title' => 'Boss Flame of Splendor Barakiel was killed',
                'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by handjobxxx.',
                'timestamp' => '1612369858',
            ),
        11 =>
            array (
                'title' => 'Boss Kernon was killed',
                'description' => 'Boss Kernon was killed. The number of attackers: 47. Last hit was dealt by ххСАДИСТх.',
                'timestamp' => '1612347946',
            ),
        12 =>
            array (
                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 15. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                'timestamp' => '1612341348',
            ),
        13 =>
            array (
                'title' => 'Boss Death Lord Hallate was killed',
                'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 11. Last hit was dealt by MPslivkA from clan BloodySaviors.',
                'timestamp' => '1612334916',
            ),
        14 =>
            array (
                'title' => 'Boss Longhorn Golkonda was killed',
                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 9. Last hit was dealt by R0CKeR from clan DiabloZ.',
                'timestamp' => '1612329014',
            ),
        15 =>
            array (
                'title' => 'Boss Varka\'s Chief Horus was killed',
                'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                'timestamp' => '1612325523',
            ),
        16 =>
            array (
                'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                'timestamp' => '1612325366',
            ),
        17 =>
            array (
                'title' => 'Boss Ketra\'s Chief Brakki was killed',
                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by Tuc0Salamanca from clan PollosHermanos.',
                'timestamp' => '1612315837',
            ),
        18 =>
            array (
                'title' => 'Boss Varka\'s Commander Mos was killed',
                'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 2. Last hit was dealt by БликСолнца from clan Хранители.',
                'timestamp' => '1612310103',
            ),
        19 =>
            array (
                'title' => 'Boss Varka\'s Hero Shadith was killed',
                'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                'timestamp' => '1612283444',
            ),
    );

}
function get_test2(){
    return array (
        0 =>
            array (
                'title' => 'Boss Varka\'s Hero Shadith was killed',
                'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by 66 from clan CORSAR.',
                'timestamp' => '1612381895',
            ),
        1 =>
            array (
                'title' => 'Boss Flame of Splendor Barakiel was killed',
                'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 8. Last hit was dealt by handjobxxx.',
                'timestamp' => '1612369858',
            ),
        2 =>
            array (
                'title' => 'Boss Kernon was killed',
                'description' => 'Boss Kernon was killed. The number of attackers: 47. Last hit was dealt by ххСАДИСТх.',
                'timestamp' => '1612347946',
            ),
        3 =>
            array (
                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 15. Last hit was dealt by Уокэйхуокомас from clan Torrents.',
                'timestamp' => '1612341348',
            ),
        4 =>
            array (
                'title' => 'Boss Death Lord Hallate was killed',
                'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 11. Last hit was dealt by MPslivkA from clan BloodySaviors.',
                'timestamp' => '1612334916',
            ),
        5 =>
            array (
                'title' => 'Boss Longhorn Golkonda was killed',
                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 9. Last hit was dealt by R0CKeR from clan DiabloZ.',
                'timestamp' => '1612329014',
            ),
        6 =>
            array (
                'title' => 'Boss Varka\'s Chief Horus was killed',
                'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                'timestamp' => '1612325523',
            ),
        7 =>
            array (
                'title' => 'Boss Ketra\'s Hero Hekaton was killed',
                'description' => 'Boss Ketra\'s Hero Hekaton was killed. The number of attackers: 1. Last hit was dealt by Mirzael from clan KingFisher.',
                'timestamp' => '1612325366',
            ),
        8 =>
            array (
                'title' => 'Boss Ketra\'s Chief Brakki was killed',
                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 2. Last hit was dealt by Tuc0Salamanca from clan PollosHermanos.',
                'timestamp' => '1612315837',
            ),
        9 =>
            array (
                'title' => 'Boss Varka\'s Commander Mos was killed',
                'description' => 'Boss Varka\'s Commander Mos was killed. The number of attackers: 2. Last hit was dealt by БликСолнца from clan Хранители.',
                'timestamp' => '1612310103',
            ),
        10 =>
            array (
                'title' => 'Boss Varka\'s Hero Shadith was killed',
                'description' => 'Boss Varka\'s Hero Shadith was killed. The number of attackers: 3. Last hit was dealt by ХхПринцхХ.',
                'timestamp' => '1612283444',
            ),
        11 =>
            array (
                'title' => 'Boss Flame of Splendor Barakiel was killed',
                'description' => 'Boss Flame of Splendor Barakiel was killed. The number of attackers: 2. Last hit was dealt by GoddessOfSin from clan Nyamki.',
                'timestamp' => '1612259714',
            ),
        12 =>
            array (
                'title' => 'Boss Longhorn Golkonda was killed',
                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by Buton from clan ObsidianUnion.',
                'timestamp' => '1612259274',
            ),
        13 =>
            array (
                'title' => 'Boss Shilen\'s Messenger Cabrio was killed',
                'description' => 'Boss Shilen\'s Messenger Cabrio was killed. The number of attackers: 25. Last hit was dealt by KotoVod149 from clan Federation.',
                'timestamp' => '1612258394',
            ),
        14 =>
            array (
                'title' => 'Boss Ketra\'s Commander Tayr was killed',
                'description' => 'Boss Ketra\'s Commander Tayr was killed. The number of attackers: 2. Last hit was dealt by BoobleGum from clan Импульсивные.',
                'timestamp' => '1612255232',
            ),
        15 =>
            array (
                'title' => 'Boss Death Lord Hallate was killed',
                'description' => 'Boss Death Lord Hallate was killed. The number of attackers: 13. Last hit was dealt by Xamochkin from clan Beehive.',
                'timestamp' => '1612248784',
            ),
        16 =>
            array (
                'title' => 'Boss Kernon was killed',
                'description' => 'Boss Kernon was killed. The number of attackers: 9. Last hit was dealt by Zubast1k from clan PrideOfKittens.',
                'timestamp' => '1612241156',
            ),
        17 =>
            array (
                'title' => 'Boss Longhorn Golkonda was killed',
                'description' => 'Boss Longhorn Golkonda was killed. The number of attackers: 12. Last hit was dealt by FalleNDestinY from clan ЧерныйЗакат.',
                'timestamp' => '1612189948',
            ),
        18 =>
            array (
                'title' => 'Boss Ketra\'s Chief Brakki was killed',
                'description' => 'Boss Ketra\'s Chief Brakki was killed. The number of attackers: 3. Last hit was dealt by ЛисоБелка from clan Beehive.',
                'timestamp' => '1612188515',
            ),
        19 =>
            array (
                'title' => 'Boss Varka\'s Chief Horus was killed',
                'description' => 'Boss Varka\'s Chief Horus was killed. The number of attackers: 2. Last hit was dealt by Флебустьер from clan GottMitUns.',
                'timestamp' => '1612178693',
            ),
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
function arrayRecursiveDiff($second, $first) {
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
