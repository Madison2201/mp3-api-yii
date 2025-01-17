<?php

namespace app\interface\services;

use app\models\LoginForm;

interface AuthServiceInterface
{
    public function auth(LoginForm $form);

}