<?php

namespace app\services;

use app\interface\repositories\UserRepositoryInterface;
use app\interface\services\AuthServiceInterface;
use app\repositories\UserRepository;
use app\models\LoginForm;
use Yii;

class AuthService implements AuthServiceInterface
{
    private UserRepository $users;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->users = $userRepository;
    }

    public function auth(LoginForm $form): array
    {

        $token = Yii::$app->jwt->createToken(['user_id' => $form->getUserId()]);

        return [
            'name' => $form->getUsername(),
            'token' => 'jwt ' . $token
        ];
    }
}