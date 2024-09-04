<?php

class Database
{
    private $host = "localhost";
    private $db_name = "dbt";
    private $username = "ospanel";
    private $password = "ospanel";
    public $pdo;

    public function get_connection()
    {
        $this->pdo = null;

        try {
            $this->pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception) {
            echo "Ошибка соединения: " . $exception->getMessage();
        }

        return $this->pdo;
    }
}