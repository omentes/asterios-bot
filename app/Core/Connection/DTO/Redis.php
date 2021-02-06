<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection\DTO;

class Redis
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var int
     */
    private $port;

    /**
     * @var int
     */
    private $database;

    public function __construct(string $host = '127.0.0.1', int $port = 6379, int $database = 0)
    {
        $this->host = $host;
        $this->port = $port;
        $this->database = $database;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return int
     */
    public function getDatabase(): int
    {
        return $this->database;
    }
}
