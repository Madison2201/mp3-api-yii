<?php

namespace app\interface\repositories;

use app\models\TagAssignments;

interface TagAssignmentsRepositoryInterface
{
    public function save(TagAssignments $assignments): void;


    public function detach(TagAssignments $assignments): void;


    public function getByCondition($condition): TagAssignments;

}