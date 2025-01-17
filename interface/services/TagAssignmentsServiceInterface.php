<?php

namespace app\interface\services;

use app\forms\TagAssignmentsForm;

interface TagAssignmentsServiceInterface
{
    public function attachTag(TagAssignmentsForm $form): void;


    public function detachTag(TagAssignmentsForm $form): void;

}