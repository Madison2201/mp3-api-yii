<?php

namespace app\forms;

use app\models\Post;
use app\models\Tag;
use app\models\TagAssignments;
use Yii;
use yii\base\Model;

class TagAssignmentsForm extends Model
{
    public  $tag_id;
    public  $post_id;
    const SCENARIO_DELETE = 'delete';
    public function rules(): array
    {
        return [
            [['tag_id', 'post_id'], 'required'],
            [['tag_id', 'post_id'], 'integer', 'min' => 1, 'max' => PHP_INT_MAX],
            ['tag_id', 'exist', 'targetClass' => Tag::class, 'targetAttribute' => 'id', 'message' => Yii::t('app', 'tag_id_not_found')],
            ['post_id', 'exist', 'targetClass' => Post::class, 'targetAttribute' => 'id', 'message' => Yii::t('app', 'post_id_not_found')],
            ['post_id', 'validateUniqueAssignment', 'on' => self::SCENARIO_DEFAULT],
            ['post_id', 'existAssignment', 'on' => self::SCENARIO_DELETE],
        ];
    }

    public function validateUniqueAssignment($attribute, $params): void
    {
        $exists = TagAssignments::find()
            ->where(['post_id' => $this->post_id, 'tag_id' => $this->tag_id])
            ->exists();
        if ($exists) {
            $this->addError($attribute, Yii::t('app', 'record_already_exists'));
        }
    }

    public function existAssignment($attribute, $params): void
    {
        $exists = TagAssignments::find()
            ->where(['post_id' => $this->post_id, 'tag_id' => $this->tag_id])
            ->exists();
        if (!$exists) {
            $this->addError($attribute, Yii::t('app', 'record_does_not_exists'));
        }
    }
}