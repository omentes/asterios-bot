<?php

declare(strict_types=1);

namespace AsteriosBot\Core;

use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Support\Singleton;

class Worker extends Singleton
{
    public static function run(string $server, bool $check = false)
    {
        $app = App::getInstance();

        try {
            $app->botRunner($server, $check);
        } catch (\Throwable $e) {
            Log::getInstance()->getLogger()->error($e->getMessage(), $e->getTrace());
        }
    }
}
