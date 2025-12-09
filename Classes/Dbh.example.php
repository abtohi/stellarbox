<?php

class Dbh
{
    private $host = "db";
    private $username = "YOUR_DB_USERNAME";
    private $pwd = "YOUR_DB_PASSWORD";
    private $dbname = "stellarbox_db";

    public function connect()
    {
        try {
            $pdo = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->pwd);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
