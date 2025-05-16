<?php

namespace App\HQ;

use PDO;
use Dotenv\Dotenv;

class DatabaseTest {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
     
        $this->host = env_app('DB_HOST','','test');
        $this->db_name = env_app('DB_NAME','','test');
        $this->username = env_app('DB_USER','','test');
        $this->password = env_app('DB_PASS','','test');
    }

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
