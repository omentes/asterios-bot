<?php
require "vendor/autoload.php";
require "_AsteriosBotManager.php";

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDO($pdo, $manager::X5);

$unique = $manager->getDeadRB($local);

pp(array_filter(array_map(function (&$x) {
	if ($x['timestamp'] < 0) {
	} else return $x;
}, $unique)));



function pp($item)
{
    echo PHP_EOL;
    var_export($item);
    echo PHP_EOL;
    die();
}

