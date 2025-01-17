<?php

namespace app\services;

use app\forms\TagForm;
use app\interface\repositories\TagRepositoryInterface;
use app\interface\services\TagServiceInterface;
use app\models\Tag;
use Throwable;
use yii\data\ActiveDataProvider;

class TagService implements TagServiceInterface
{
    private TagRepositoryInterface $tags;

    public function __construct(TagRepositoryInterface $tags)
    {
        $this->tags = $tags;
    }

    public function getAll($params): ActiveDataProvider
    {
        return $this->tags->search($params);
    }

    public function create(TagForm $form): Tag
    {
        $tag = Tag::create($form->title);
        $this->tags->save($tag);
        return $tag;
    }

    public function getTag(int $id): Tag
    {
        return $this->tags->getById($id);
    }

    public function edit(Tag $tag, TagForm $form): void
    {
        $tag->edit(
            $form->title,
        );
        $this->tags->save($tag);
    }

    /**
     * @throws Throwable
     */
    public function remove(int $id): void
    {
        $tag = $this->tags->getById($id);
        $this->tags->remove($tag);
    }


}