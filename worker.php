<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Channel\Checker;
use AsteriosBot\Channel\Parser;
use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;

$app = App::getInstance();
$checker = new Checker();
$parser = new Parser();
$logger = Log::getInstance()->getLogger();
$expectedTime = time() + 60; // +1 min in seconds
$oneSecond = time();
while (true) {
    $now = time();
    if ($now >= $oneSecond) {
        $oneSecond = $now + 1;
        try {
            $parser->execute('x5');
            $parser->execute('x3');
            $checker->execute('x5');
            $checker->execute('x3');
        } catch (\Throwable $e) {
            $logger->error($e->getMessage(), $e->getTrace());
        }
    }
    if ($expectedTime < $now) {
        die(0);
    }
}
