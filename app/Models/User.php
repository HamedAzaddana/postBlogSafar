<?php

namespace App\Models;

use App\HQ\Model;

class User extends Model
{
    public function createUser($username, $email, $password, $role)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (`username`, `email`, `password`,`role`) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $email, $hashedPassword, $role]);
    }
    public function firstOrCreateUser($username, $email, $password, $role)
    {
        $sql = "SELECT * FROM users WHERE username = ? AND email = ?";
        $stmt = $this->query($sql, [$username, $email]);
        $fetched = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($fetched) {
            return $fetched;
        } else {
            $this->createUser($username, $email, $password, $role);
            return $this->firstOrCreateUser($username, $email, $password, $role);
        }
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->query($sql, [$username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->query($sql, [$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
