<?php

declare(strict_types=1);

namespace AsteriosBot\Core;

use AsteriosBot\Bot\Checker;
use AsteriosBot\Bot\Parser;
use AsteriosBot\Core\Support\Config;
use AsteriosBot\Core\Support\Singleton;
use Dotenv\Dotenv;
use Prometheus\Exception\MetricsRegistrationException;

final class App extends Singleton
{
    /**
     * @var Config
     */
    private $config;

    /**
     *
     */
    public function __construct()
    {
        $paths = explode('/', __DIR__);
        array_pop($paths);
        array_pop($paths);
        $path = implode('/', $paths);
        $env = Dotenv::createUnsafeImmutable($path . '/');
        $env->load();
        $this->config = new Config();
        date_default_timezone_set('Europe/Moscow');
    }

    /**
     * @param string $server
     * @param bool   $check
     *
     * @throws MetricsRegistrationException
     * @throws Exception\BadServerException
     */
    public function botRunner(string $server, bool $check): void
    {
        if ($check) {
            (new Checker())->execute($server);
        } else {
            (new Parser())->execute($server);
        }
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}
