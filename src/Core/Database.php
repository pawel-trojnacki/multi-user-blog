<?php

namespace App\Core;

use PDO;

class Database
{
    private const DB_DRIVER = 'DB_DRIVER';
    private const DB_HOST = 'DB_HOST';
    private const DB_PORT = 'DB_PORT';
    private const DB_NAME = 'DB_NAME';
    private const DB_USER = 'DB_USER';
    private const DB_PASSWORD = 'DB_PASSWORD';

    private string $dns;
    private string $user;
    private string $password;

    private PDO $pdo;

    public function __construct()
    {
        $this->setConfig();
        $this->setPdo();
    }

    private function setConfig(): void
    {
        $config = parse_ini_file(ROOT_DIR . '/config/config.ini');

        $this->dns = $config[self::DB_DRIVER] . ':host=' . $config[self::DB_HOST] . ';port=' . $config[self::DB_PORT] . ';dbname=' . $config[self::DB_NAME];

        $this->user = $config[self::DB_USER];

        $this->password = $config[self::DB_PASSWORD];
    }

    private function setPdo(): void
    {
        $this->pdo = new PDO($this->dns, $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function connection(): PDO
    {
        return $this->pdo;
    }
}
