<?php

namespace App\Models;

use App\HQ\Model;

class Post extends Model
{
    public function getAllPosts()
    {
        $sql = "SELECT * FROM posts";
        $stmt = $this->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPostById($id)
    {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->query($sql, [$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createPost($userId, $title, $description, $image)
    {
        $sql = "INSERT INTO posts (`user_id`, `title`, `description`, `image`) VALUES (?, ?, ?, ?)";
        $this->query($sql, [$userId, $title, $description, $image]);
    }
    public function firstOrCreatePost($userId, $title, $description, $image)
    {
        $sql = "SELECT * FROM posts WHERE title = ? AND user_id = ?";
        $stmt = $this->query($sql, [$title,$userId]);
        $fetched= $stmt->fetch(\PDO::FETCH_ASSOC);
        if($fetched){
            return $fetched;
        }else{
            $this->createPost($userId, $title, $description, $image);
            return $this->firstOrCreatePost($userId, $title, $description, $image);
        }
    }
}
