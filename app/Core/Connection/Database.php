<?php
declare(strict_types = 1);

namespace AsteriosBot\Core\Connection;

use AsteriosBot\Core\Support\Singleton;
use Slim\PDO\Database as DB;

class Database extends Singleton
{
    /**
     * @var DB
     */
    private $connection;
    
    /**
     * Database constructor.
     */
    protected function __construct()
    {
        $dbhost = getenv('DB_HOST');
        $dbname = 'test';//getenv('DB_NAME');
        $dsn = "mysql:host={$dbhost};dbname={$dbname};charset=utf8";
        $usr = getenv('DB_USERNAME');
        $pwd = getenv('DB_PASSWORD');
        $this->connection = new DB($dsn, $usr, $pwd);
    }
    
    /**
     * @return DB
     */
    public function getConnection(): DB
    {
        return $this->connection;
    }
}