<?php
require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Core\Worker;

if (validate()) {
    $server = $argv[1];
    $check = isset($argv[2]) && $argv[2] == 'true';
    Worker::run($server, $check);
}

function validate(): bool
{
    return isset($argv[1]) &&
        isset($argv[2]) &&
        in_array($argv[1], ['x5', 'x7', 'x3']) &&
        in_array($argv[2], ['true', 'false']);
}
