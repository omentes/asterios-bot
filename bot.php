<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\Bot;

$bot = Bot::getInstance();
while (true) {
    $bot->run();
    usleep(500000);
}
