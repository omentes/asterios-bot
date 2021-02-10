<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Channel\Checker;
use AsteriosBot\Channel\Parser;
use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;

if (isset($argv[1]) && validate($argv[1])) {
    $server = $argv[1];
    $now = time();
    $expectedTime = $now + 10 * 60;
    $oneSecond = time();
    $app = App::getInstance();
    $checker = new Checker();
    $parser = new Parser();
    while (true) {
        $now = time();
        if (time() >= $oneSecond) {
            $oneSecond = $now + 1;
            try {
                $parser->execute($server);
                $checker->execute($server);
            } catch (\Throwable $e) {
                Log::getInstance()->getLogger()->error($e->getMessage(), $e->getTrace());
            }
        }
        if ($expectedTime <= $now) {
            die(0);
        }
    }
}

function validate($first): bool
{
    return in_array($first, ['x5', 'x7', 'x3']);
}
