<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Bot\Bot;
use AsteriosBot\Core\Connection\Metrics;
use Prometheus\RenderTextFormat;

if (isset($_REQUEST['uri'])) {
    if ($_REQUEST['uri'] == '/metrics') {
        $metrics = Metrics::getInstance();
        $renderer = new RenderTextFormat();
        $result = $renderer->render($metrics->getRegistry()->getMetricFamilySamples());
        header('Content-type: ' . RenderTextFormat::MIME_TYPE);
        echo $result;
        die;
    }
    if ($_REQUEST['uri'] == '/bots') {
        $bot = Bot::getInstance();
        $bot->runHook();
        echo json_encode(
            ["runHook" => "ok"]
        );
        die;
    }
}

echo json_encode(
    ["status" => "ok"]
);
