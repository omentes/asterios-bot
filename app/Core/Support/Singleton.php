<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Support;

use AsteriosBot\Core\Exception\DeserializeException;
use AsteriosBot\Core\Exception\SerializeException;

class Singleton
{
    protected static $instances = [];

    /**
     * Singleton constructor.
     */
    protected function __construct()
    {
        // do nothing
    }

    /**
     * Disable clone object.
     */
    protected function __clone()
    {
        // do nothing
    }

    /**
     * Disable serialize object.
     *
     * @throws SerializeException
     */
    public function __sleep()
    {
        throw new SerializeException("Cannot serialize singleton");
    }

    /**
     * Disable deserialize object.
     *
     * @throws DeserializeException
     */
    public function __wakeup()
    {
        throw new DeserializeException("Cannot deserialize singleton");
    }

    /**
     * @return static
     */
    public static function getInstance(): Singleton
    {
        $subclass = static::class;
        if (!isset(self::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }
        return self::$instances[$subclass];
    }
}
