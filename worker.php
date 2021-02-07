<?php
require __DIR__ . '/vendor/autoload.php';

use AsteriosBot\Core\Worker;

if (isset($argv[1]) &&
    isset($argv[2]) &&
    validate($argv[1], $argv[2])
) {
    $server = $argv[1];
    $check = isset($argv[2]) && $argv[2] == 'true';
    $now = time();
    $expectedTime = $now + 10 * 60;
    while (true) {
        Worker::run($server, $check);
        if ($expectedTime === time()) {
            die(0);
        }
    }
}

function validate($first, $second): bool
{
    return in_array($first, ['x5', 'x7', 'x3']) &&
        in_array($second, ['true', 'false']);
}
