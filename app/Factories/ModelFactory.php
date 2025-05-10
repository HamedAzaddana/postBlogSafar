<?php

namespace App\Factories;

use App\Models\Post;
use App\Models\User;

class ModelFactory implements ModelFactoryInterface {
    public function createPostModel() {
        return new Post();
    }

    public function createUserModel() {
        return new User();
    }
}
