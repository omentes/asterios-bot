<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, $manager::X5);
$remote = $manager->getRSSData($manager::URL_X5);
$newRaids =    arrayRecursiveDiff($remote, $local);
//pp(check_diff_multi($remote, $local));
echo count($newRaids) . ' ';
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

$counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_x5', 'it increases');
$counter->incBy(1, []);

foreach ($newRaids as $raid) {
    $manager->trySend($pdo, $raid, $manager::X5);
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
