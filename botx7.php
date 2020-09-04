<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";
error_reporting(E_ERROR | E_PARSE);

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, $manager::X7);
$remote = $manager->getRSSData($manager::URL_X7);
$newRaids =    arrayRecursiveDiff($remote, $local);
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

$counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_x7', 'it increases');
$counter->incBy(1, []);

echo "[X7] " . date("Y-m-d H:i:s") . ' ' . count($newRaids) . PHP_EOL;

foreach ($newRaids as $raid) {
    $manager->trySend($pdo, $raid, $manager::X7);
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

