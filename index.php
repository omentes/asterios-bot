<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\AnswerHandler;
use AsteriosBot\Bot\Bot;
use AsteriosBot\Bot\BotHelper;
use AsteriosBot\Core\Connection\Metrics;

$bot = Bot::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bot->runHook();
} elseif (isset($_GET["server"]) && in_array($_GET["server"], ['x3','x5', 'x7'])) {
    $server = htmlspecialchars($_GET["server"]);
    Metrics::getInstance()->increaseMetric('usage_image');
    $dto = BotHelper::parseText("[$server]");
    header('Content-type: image/svg+xml');
    echo (new AnswerHandler($dto))->getSvg();
} else {
    echo json_encode(
        ["asterios-bot" => "ok"]
    );
}
