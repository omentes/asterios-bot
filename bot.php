<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\Bot;

$bot = Bot::getInstance();
$expectedTime = time() + 10 * 60;
while (true) {
    $bot->run();
    if ($expectedTime <= time()) {
        die(0);
    }
}
