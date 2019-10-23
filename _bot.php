<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, $manager::X5);
$remote = $manager->getRSSData($manager::URL_X5);
$newRaids = array_diff_key($remote, $local);

echo '[log] parse done, diff count ' . count($newRaids) . PHP_EOL;
foreach ($newRaids as $raid) {
    $manager->trySend($pdo, $raid, $manager::X5);
}

function pp($item)
{
    var_export($item);
    die();
}

