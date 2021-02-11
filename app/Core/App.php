<?php

declare(strict_types=1);

namespace AsteriosBot\Core;

use AsteriosBot\Core\Support\Config;
use AsteriosBot\Core\Support\Singleton;
use Dotenv\Dotenv;

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
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}
