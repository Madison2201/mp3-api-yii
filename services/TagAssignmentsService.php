<?php

namespace app\services;

use app\forms\TagAssignmentsForm;
use app\interface\repositories\TagAssignmentsRepositoryInterface;
use app\interface\services\TagAssignmentsServiceInterface;
use app\models\TagAssignments;
use Throwable;

class TagAssignmentsService implements TagAssignmentsServiceInterface
{

    private TagAssignmentsRepositoryInterface $repository;

    public function __construct(TagAssignmentsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function attachTag(TagAssignmentsForm $form): void
    {
        $assigment = TagAssignments::create(
            $form->tag_id,
            $form->post_id
        );
        $this->repository->save($assigment);
    }

    /**
     * @throws Throwable
     */
    public function detachTag(TagAssignmentsForm $form): void
    {
        $assignments = $this->repository->getByCondition(['post_id' => $form->post_id, 'tag_id' => $form->tag_id]);
        $this->repository->detach($assignments);

    }
}