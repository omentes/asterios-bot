<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$raids = $manager->getRaidsLikeThis($pdo, 'Mos', $manager::X5);

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
        if (!$results[$hours]) {
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
