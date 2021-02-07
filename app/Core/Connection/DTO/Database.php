<?php

declare(strict_types=1);

namespace AsteriosBot\Core\Connection\DTO;

class Database
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $dsn;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * DatabaseDTO constructor.
     *
     * @param string $host
     * @param string $name
     * @param string $user
     * @param string $password
     */
    public function __construct(
        string $host,
        string $name,
        string $user,
        string $password
    ) {
        $this->host = $host;
        $this->name = $name;
        $this->user = $user;
        $this->password = $password;
        $this->dsn = "mysql:host={$host};dbname={$name};charset=utf8";
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
