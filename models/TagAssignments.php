<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $post_id
 * @property int $tag_id
 */
class TagAssignments extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%tag_assignments}}';
    }
    public static function create(int $tag_id, int $post_id): self
    {
        $assignment = new self();
        $assignment->tag_id = $tag_id;
        $assignment->post_id = $post_id;
        return $assignment;
    }
}