<?php

require_once 'DBConfig.php';

class DB
{
    private $config;
    private $connection;
    private static $instance = null;

    private function __construct()
    {
        $this->config = new DBConfig();

        try {
            $this->connection = new PDO(...$this->config->getPDOCreationParams());
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        } catch (PDOException $e) {
            http_response_code(500);
            exit('Error al establecer conexión con la base de datos');
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DB();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
