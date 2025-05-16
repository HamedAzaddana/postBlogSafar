<?php

use App\HQ\DatabaseTest;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    private $db;
    private $userModel;

    protected function setUp(): void
    {
        $database = new DatabaseTest();
        $this->db = $database->getConnection();
        include __DIR__ . "/migrate.php";
        $this->userModel = new User($this->db);

        $this->db->exec("INSERT INTO users (`username`, `email`,`password`,`role`) VALUES ('HasanKachal', 'HasanKachal@gmail.com','" . password_hash('123456', PASSWORD_BCRYPT) . "','user')");
        $this->db->exec("INSERT INTO users (`username`, `email`,`password`,`role`) VALUES ('Mola021', 'Mola021@gmail.com','" . password_hash('54yrtjftr', PASSWORD_BCRYPT) . "','admin')");
        $this->db->exec("INSERT INTO users (`username`, `email`,`password`,`role`) VALUES ('reza_HA1377', 'reza_HA1377@gmail.com','" . password_hash('j87yujgtdy', PASSWORD_BCRYPT) . "','user')");
    }

    public function testGetAllUsers()
    {
        $users = $this->userModel->getAllUsers();
        $this->assertIsArray($users);
        $this->assertGreaterThan(0, count($users));
        $this->assertEquals('Mola021', $users[1]['username']);
        $this->assertEquals('reza_HA1377@gmail.com', $users[2]['email']);
    }

    public function testGetUserByUsername()
    {
        $user = $this->userModel->getUserByUsername("HasanKachal");

        $this->assertEquals('HasanKachal@gmail.com', $user['email']);
        $this->assertEquals('user', $user['role']);
    }

    public function testCreateUser()
    {
        $result = $this->userModel->createUser("Koma23", "Koma23@gmail.com", "hddhhdh3", 'user');

        $this->assertTrue($result);

        $user = $this->userModel->getUserByEmail("Koma23@gmail.com");
        $this->assertEquals('Koma23', $user['username']);
        $this->assertEquals('user', $user['role']);
    }

    protected function tearDown(): void
    {
        $this->db->exec("DELETE FROM users");

        parent::tearDown();
    }
}
