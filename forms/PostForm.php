<?php

namespace app\forms;

use app\models\Post;
use Yii;
use yii\base\Model;
use yii\web\ForbiddenHttpException;

class PostForm extends Model
{
    public $title;
    public $description;
    public $file_url;
    public $file;
    public $created_at;
    public $updated_at;
    public $status;
    public $user_id;
    private $_post;

    public function __construct(Post $post = null, $config = [])
    {
        if ($post) {
            $this->title = $post->title;
            $this->description = $post->description;
            $this->file_url = $post->file_url;
            $this->created_at = $post->created_at;
            $this->updated_at = $post->updated_at;
            $this->status = $post->status;
            $this->user_id = $post->user_id;
            $this->_post = $post;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'description',], 'required'],
            [['title', 'description'], 'string', 'max' => 255],
            [['file_url'], 'string', 'max' => 255],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'validateUserId'],
        ];
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function validateUserId($attribute, $params): void
    {
        if ($this->user_id !== \Yii::$app->user->id) {
            throw new ForbiddenHttpException(Yii::t('app', 'forbidden_error'));
        }
    }
}