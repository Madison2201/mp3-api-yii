<?php

namespace app\services;

use app\forms\PostForm;
use app\interface\repositories\PostRepositoryInterface;
use app\interface\services\PostServiceInterface;
use app\models\Post;
use Throwable;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class PostService implements PostServiceInterface
{
    private PostRepositoryInterface $posts;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->posts = $postRepository;
    }

    public function getPosts(array $params): ActiveDataProvider
    {
        return $this->posts->search($params);
    }

    /**
     * @throws NotFoundHttpException
     */
    public function getPost(int $id): Post
    {
        return $this->posts->getById($id);
    }

    public function create(PostForm $form): Post
    {
        $post = Post::create(
            $form->title,
            $form->description,
            $form->file_url
        );
        $this->posts->save($post);
        return $post;
    }

    public function edit(Post $post, PostForm $form): void
    {
        $post->edit(
            $form->title,
            $form->description,
            $form->file_url,
            $form->status
        );
        $this->posts->save($post);
    }

    /**
     * @throws Throwable
     * @throws ForbiddenHttpException
     */
    public function remove(int $id): void
    {
        $post = $this->posts->getById($id);
        if ($post->user_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException(Yii::t('app', 'forbidden_error'));
        }
        $this->posts->remove($post);
    }
}