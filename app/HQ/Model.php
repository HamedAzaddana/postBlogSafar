<?php

namespace App\HQ;

use PDO;

class Model {
    protected $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function query($sql, $params = []) {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
