<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\Bot;

$bot = Bot::getInstance();
while (true) {
    $bot->notify();
    usleep(500000);
}
