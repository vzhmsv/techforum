<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proposal".
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string $body
 * @property int $user_id
 * @property string $created_at
 *
 * @property User $user
 */
class Proposal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proposal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','body'], 'required'],
            [['name'], 'string'],
            [['body'], 'string'],
            [['user_id'], 'integer'],
            [['created_at'], 'string'],
            [['image'], 'file', 'extensions' => 'png, jpg', 'on'=>'update'],
            [['user_id'], 'default', 'value'=>Yii::$app->user->getId()]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'image' => Yii::t('app', 'Изображение'),
            'name' => Yii::t('app', 'Название'),
            'body' => Yii::t('app', 'Основной текст'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('uploads/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }
}
