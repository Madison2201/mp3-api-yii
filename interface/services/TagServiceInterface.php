<?php

namespace app\interface\services;

use app\forms\TagForm;
use app\models\Tag;
use yii\data\ActiveDataProvider;

interface TagServiceInterface
{
    public function getAll($params): ActiveDataProvider;


    public function create(TagForm $form): Tag;


    public function getTag(int $id): Tag;


    public function edit(Tag $tag, TagForm $form): void;


    public function remove(int $id): void;


}