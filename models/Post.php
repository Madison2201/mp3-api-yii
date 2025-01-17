<?php

namespace app\models;

use app\enums\PostStatus;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $file_url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $user_id
 */
class Post extends ActiveRecord
{
    public static function tableName(): string
    {
        return "{{%post}}";
    }

    public static function create(string $title, string $description,string $file_url): self
    {
        $post = new static();
        $post->title = $title;
        $post->description = $description;
        $post->file_url = $file_url;
        $post->created_at = time();
        $post->status = PostStatus::ACTIVE->value;
        $post->user_id = Yii::$app->user->id;
        return $post;
    }

    public function edit(string $title, string $description,string $file_url, int $status): void
    {
        $this->title = $title;
        $this->description = $description;
        $this->file_url = $file_url;
        $this->status = $status;
        $this->updated_at = time();
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'description',
            'status',
            'file_url',
            'created_at' => function () {
                return date('Y-m-d H:i:s', $this->created_at);
            },
        ];
    }

    /**
     * @throws InvalidConfigException
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('tag_assignments', ['post_id' => 'id']);
    }

    public function extraFields()
    {
        return [
            'tags',
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = self::find()->alias('p');

        $query->joinWith('tags t');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $params['pageSize'] ?? 10,
            ],
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
                'attributes' => [
                    'id',
                    'title',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);

        $this->setAttributes($params, false);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        if (!empty($this->created_at)) {
            $timestamp = strtotime($this->created_at);
            $query->andFilterWhere(['=', 'created_at', $timestamp]);
        }
        if (!empty($params['tag_id'])) {
            $query->andWhere(['t.id' => $params['tag_id']]);
        }

        return $dataProvider;
    }

}