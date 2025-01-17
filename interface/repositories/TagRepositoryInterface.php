<?php

namespace app\interface\repositories;

use app\models\Tag;
use yii\data\ActiveDataProvider;

interface TagRepositoryInterface
{
    public function getAll(): array;


    public function save(Tag $tag): void;

    public function remove(Tag $tag): void;


    public function getById(int $id): Tag;


    public function search($params): ActiveDataProvider;

}