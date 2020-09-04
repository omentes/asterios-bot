<?php
require "vendor/autoload.php";
require "_AsteriosBotManager.php";
error_reporting(E_ERROR | E_PARSE);

$manager = new _AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, 10);
$remote = $manager->getRSSData($manager::URL_X5);
$newRaids =    arrayRecursiveDiff($local, $remote);
echo "[X5] " . date("Y-m-d H:i:s") . ' ' . count($newRaids) . PHP_EOL;
$fp = fopen('local.json', 'w');
fwrite($fp, json_encode($local));
fclose($fp);
$fp2 = fopen('remote.json', 'w');
fwrite($fp2, json_encode($remote));
fclose($fp2);
//pp($newRaids);
foreach ($newRaids as $raid) {
    $manager->trySend($pdo, $raid, 10);
}

function pp($item)
{
    echo PHP_EOL;
    echo 'pp' . PHP_EOL;
    var_export($item);
    echo PHP_EOL;
    die();
}
function arrayRecursiveDiff($first, $second) {
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
