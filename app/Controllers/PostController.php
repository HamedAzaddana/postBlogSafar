<?php

namespace App\Controllers;

use App\HQ\Controller;
use App\Models\Post;

class PostController extends Controller
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = factory_model_instance('post');
    }

    public function home()
    {
        return redirect("/posts");
    }
    public function index()
    {
        $posts = $this->postModel->getAllPosts();
        return view("post/index",compact('posts'),"layout","Posts Page");
    }

    public function getFile($request)
    {
        $file = $request['name'];
        load_file("uploads/".$file);
    }

    public function show()
    {
        $id = request('id');
        $post = $this->postModel->getPostById($id);
        return view("post/show",compact('post','id'));
    }

    public function create()
    {
        //TODO
        return redirect("/posts");
    }
}
