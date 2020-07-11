<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";

$manager = new AsteriosBotManager();

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

$counter = $registry->getOrRegisterCounter('asterios_bot', 'healthcheck_test', 'it increases');
$counter->incBy(1, []);


$pdo = $manager->getPDO();
$raids = $manager->getRaidsLikeThis($pdo, 'Shadit', $manager::X5);

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






function pp($item)
{
    echo PHP_EOL;
    echo 'pp' . PHP_EOL;
    var_export($item);
    echo PHP_EOL;
    die();
}
