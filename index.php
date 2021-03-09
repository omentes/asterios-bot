<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\Bot;

$bot = Bot::getInstance();
$bot->runHook();
echo json_encode(
    ["asterios-bot" => "ok"]
);
