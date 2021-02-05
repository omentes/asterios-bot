<?php
declare(strict_types = 1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Support\Singleton;
use Predis\Client;

class Cache extends Singleton
{
    /**
     * @var Client
     */
    private $connection;
    
    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $this->connection = new Client();
    }
    
    /**
     * @return Client
     */
    public function getConnection(): Client
    {
        return $this->connection;
    }
}
