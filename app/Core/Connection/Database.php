<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Support\Config;
use AsteriosBot\Core\Support\Singleton;
use FaaPz\PDO\Database as DB;

class Database extends Singleton
{
    /**
     * @var DB
     */
    protected DB $connection;

    /**
     * @var Config
     */
    protected Config $config;

    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $this->config = App::getInstance()->getConfig();
        $dto = $this->config->getDatabaseDTO();
        $this->connection = new DB($dto->getDsn(), $dto->getUser(), $dto->getPassword());
    }

    /**
     * @return DB
     */
    public function getConnection(): DB
    {
        return $this->connection;
    }
}
