<?php

namespace app\interface\services;

use app\forms\PostForm;
use app\models\Post;

interface PostServiceInterface
{
    public function getPosts(array $params);


    public function getPost(int $id);


    public function create(PostForm $form): Post;


    public function edit(Post $post, PostForm $form): void;


    public function remove(int $id): void;

}