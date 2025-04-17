<?php
namespace app\models;

use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    public static function tableName()
    {
        return 'messages';
    }

    public function rules()
    {
        return [
            [['topic_id', 'user_id', 'content'], 'required'],
            [['topic_id', 'user_id'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_id' => 'ID темы',
            'user_id' => 'ID пользователя',
            'content' => 'Текст сообщения',
            'created_at' => 'Время создания',
        ];
    }

    public function getTopic()
    {
        return $this->hasOne(Topic::class, ['id' => 'topic_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}