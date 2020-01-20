<?php
require "vendor/autoload.php";
require "AsteriosBotManager.php";

$manager = new AsteriosBotManager();

$pdo = $manager->getPDO();
$local = $manager->getDataPDOid($pdo, $manager::X5);

$q = $manager->getDeadRB($local);

$r = array_filter(array_map(function (&$x) {
	if ($x['timestamp'] > 0) {
		return $x;
	} else return null;
}, $q));

//pp($r);
foreach ($r as $record) {
    
	$time = $record['timestamp'];
        $res = $manager->checkRespawnTime($time);
	if ($res > 0) {
	    $manager->alarm($pdo, $record, $res);
	}
}
/*  pp(array_map(function ($t) {
	$t['timestamp'] = date('H:i', $t['timestamp']);
	return $t;
}, $r));
/* */
function pp($item)
{
    echo PHP_EOL;
    var_export($item);
    echo PHP_EOL;
    die();
}

