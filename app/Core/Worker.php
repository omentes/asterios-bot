<?php
declare(strict_types = 1);

namespace AsteriosBot\Core;

use AsteriosBot\Core\Support\Singleton;

class Worker extends Singleton
{
    public static function run(string $server, bool $check = false, int $counter = 100)
    {
        $app = App::run();
        while ($counter--) {
            $app->botRunner($server, $check);
        }
    }
}
