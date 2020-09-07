<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";
error_reporting(E_ERROR | E_PARSE);

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, $manager::X3);
$remote = $manager->getRSSData($manager::URL_X3);
$newRaids =    arrayRecursiveDiff($remote, $local);
echo "[X3] " . date("Y-m-d H:i:s") . ' ' . count($newRaids) . PHP_EOL;
if (count($remote)) {
    \Prometheus\Storage\Redis::setDefaultOptions(
        [
            'host' => '127.0.0.1',
            'port' => 6379,
            'password' => null,
            'timeout' => 0.1, // in seconds
            'read_timeout' => '10', // in seconds
            'persistent_connections' => false
        ]
    );
    $registry = \Prometheus\CollectorRegistry::getDefault();
    $counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_x3', 'it increases');
    $counter->incBy(1, []);
}


foreach ($newRaids as $raid) {
    $manager->trySend($pdo, $raid, $manager::X3);
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
