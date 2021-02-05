<?php
declare(strict_types = 1);

namespace AsteriosBot\Core;

use AsteriosBot\Bot\Checker;
use AsteriosBot\Bot\Runner;
use Dotenv\Dotenv;
use Exception;

final class App
{
    /**
     * @var array
     */
    protected static $registry = [];
    
    /**
     *
     */
    public static function run(): self
    {
        $paths = explode('/', __DIR__);
        array_pop($paths);
        array_pop($paths);
        $path = implode('/', $paths);
        $env = Dotenv::createUnsafeImmutable($path . '/');
        $env->load();
    }
    
    /**
     * @param string $key
     * @param $value
     */
    public static function bind(string $key, $value): void
    {
        static::$registry[$key] = $value;
    }
    
    /**
     * @param string $key
     * @return mixed
     * @throws Exception
     */
    public static function get(string $key)
    {
        if (!self::exist($key)) {
            throw new Exception('No {$key} is bound in the container.');
        }
        
        return static::$registry[$key];
    }
    
    /**
     * @param string $key
     * @return bool
     */
    public static function exist(string $key): bool
    {
        return array_key_exists($key, static::$registry);
    }
    
    /**
     * @param string $server
     * @param bool   $check
     */
    public function botRunner(string $server, bool $check): void
    {
        if ($check) {
            (new Checker())->execute($server);
        } else {
            (new Runner())->execute($server);
        }
    }
}