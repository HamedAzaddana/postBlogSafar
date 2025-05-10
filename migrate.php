<?php

require_once 'vendor/autoload.php';

use App\HQ\Database;
use App\Models\Post;
use App\Models\User;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = (new Database())->getConnection();

// Create Users table
$query = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
";
$db->exec($query);

// Create Posts table
$query = "
    CREATE TABLE IF NOT EXISTS posts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        title VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        image VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
";
$db->exec($query);

echo "Creating Tables Success !";

//Seed database 

$userModel = new User();
$userModel->firstOrCreateUser("Admin", "admin@gmail.com", "123456", "admin");
$userModel->firstOrCreateUser("Hamed", "hamed@gmail.com", "abcdef", "user");
$userModel->firstOrCreateUser("Asad021", "Asad021@gmail.com", "asad9090", "admin");


$postModel = new Post();
$postModel->firstOrCreatePost(1, "پست اول", " 1 لورم ایپسون متن تستی من", "/uploads/beaut.jpg");
$postModel->firstOrCreatePost(3, "پست دوم", " 2 لورم ایپسون متن تستی من", "/uploads/down.png");
$postModel->firstOrCreatePost(1, "پست سوم", " 3 لورم ایپسون متن تستی من", "/uploads/Tulips.jpg");
$postModel->firstOrCreatePost(3, "پست چهارم", " 4 لورم ایپسون متن تستی من", "/uploads/down.png");

echo "Seeding Tables Success !";
