<?php
declare(strict_types = 1);

namespace AsteriosBot\Core;

use AsteriosBot\Bot\Checker;
use AsteriosBot\Bot\Parser;
use AsteriosBot\Core\Support\Singleton;
use Dotenv\Dotenv;
use Prometheus\Exception\MetricsRegistrationException;

final class App extends Singleton
{
    /**
     *
     */
    public function run(): void
    {
        $paths = explode('/', __DIR__);
        array_pop($paths);
        array_pop($paths);
        $path = implode('/', $paths);
        $env = Dotenv::createUnsafeImmutable($path . '/');
        $env->load();
    }
    
    /**
     * @param string $server
     * @param bool   $check
     *
     * @throws MetricsRegistrationException
     */
    public function botRunner(string $server, bool $check): void
    {
        if ($check) {
            (new Checker())->execute($server);
        } else {
            (new Parser())->execute($server);
        }
    }
}