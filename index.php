<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\AnswerHandler;
use AsteriosBot\Bot\Bot;
use AsteriosBot\Bot\BotHelper;
use AsteriosBot\Core\Connection\Metrics;

$bot = Bot::getInstance();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bot->runHook();
} elseif (isset($_GET["server"]) && in_array($_GET["server"], ['x3','x5', 'x7']) && isset($_GET["html"])) {
    $server = htmlspecialchars($_GET["server"]);
    Metrics::getInstance()->increaseMetric('usage_html');
    $dto = BotHelper::parseText("[$server]");
    echo (new AnswerHandler($dto))->getHtml();
} elseif (isset($_GET["server"]) && in_array($_GET["server"], ['x3','x5', 'x7'])) {
    $server = htmlspecialchars($_GET["server"]);
    $dark = isset( $_GET["color"]) && 'dark' === $_GET["color"];
    header('Log: ' . intval($dark));
    Metrics::getInstance()->increaseMetric('usage_image');
    $dto = BotHelper::parseText("[$server]");
    header('Content-type: image/svg+xml');
    echo (new AnswerHandler($dto))->getSvg($dark);
} elseif (isset($_GET["terms"])) {
    include('terms.html');
} else {
    echo json_encode(
        ["asterios-bot" => "ok"]
    );
}
