<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Support\Singleton;
use Predis\Client;

class Cache extends Singleton
{
    /**
     * @var Client
     */
    private Client $connection;

    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $dto = App::getInstance()->getConfig()->getRedisDTO();
        $this->connection = new Client(
            [
            'host' => $dto->getHost(),
            'port' => $dto->getPort(),
            'database' => $dto->getDatabase(),
            ]
        );
    }

    /**
     * @return Client
     */
    public function getConnection(): Client
    {
        return $this->connection;
    }
}
