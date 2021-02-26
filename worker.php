<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Channel\Checker;
use AsteriosBot\Channel\Parser;
use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;

$app = App::getInstance();
$checker = new Checker();
$parser = new Parser();
$servers = $app->getConfig()->getEnableServers();
$logger = Log::getInstance()->getLogger();
while (true) {
    try {
        foreach ($servers as $server) {
            $parser->execute($server);
            $checker->execute($server);
        }
        usleep(500000);
    } catch (\Throwable $e) {
        $logger->error($e->getMessage(), $e->getTrace());
    }

}
