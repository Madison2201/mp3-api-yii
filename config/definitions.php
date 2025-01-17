<?php

use app\interface\repositories\PostRepositoryInterface;
use app\interface\repositories\TagAssignmentsRepositoryInterface;
use app\interface\repositories\TagRepositoryInterface;
use app\interface\repositories\UserRepositoryInterface;
use app\interface\services\AuthServiceInterface;
use app\interface\services\PostServiceInterface;
use app\interface\services\TagAssignmentsServiceInterface;
use app\interface\services\TagServiceInterface;
use app\repositories\PostRepository;
use app\repositories\TagAssignmentsRepository;
use app\repositories\TagRepository;
use app\repositories\UserRepository;
use app\services\AuthService;
use app\services\PostService;
use app\services\TagAssignmentsService;
use app\services\TagService;

return [
    PostServiceInterface::class => PostService::class,
    PostRepositoryInterface::class => PostRepository::class,
    AuthServiceInterface::class => AuthService::class,
    UserRepositoryInterface::class => UserRepository::class,
    TagServiceInterface::class => TagService::class,
    TagRepositoryInterface::class => TagRepository::class,
    TagAssignmentsServiceInterface::class => TagAssignmentsService::class,
    TagAssignmentsRepositoryInterface::class => TagAssignmentsRepository::class,
];