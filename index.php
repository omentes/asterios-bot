<?php

require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Core\Connection\Metrics;
use Prometheus\RenderTextFormat;

if (isset($_REQUEST['uri']) && $_REQUEST['uri'] == '/metrics') {
    $metrics = Metrics::getInstance();
    $renderer = new RenderTextFormat();
    $result = $renderer->render($metrics->getRegistry()->getMetricFamilySamples());
    header('Content-type: ' . RenderTextFormat::MIME_TYPE);
    echo $result;
    die;
}

echo json_encode(
    ["status" => "ok"]
);
