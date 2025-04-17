<?php
namespace app\models;

use yii\db\ActiveRecord;

class Topic extends ActiveRecord
{
    public static function tableName()
    {
        return 'topics';
    }

    public function rules()
    {
        return [
            [['title', 'description', 'user_id'], 'required'],
            [['description'], 'string'],
            [['user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название темы',
            'description' => 'Описание темы',
            'user_id' => 'ID пользователя',
            'created_at' => 'Время создания',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Message::class, ['topic_id' => 'id']);
    }
}