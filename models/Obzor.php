<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obzor".
 *
 * @property int $id
 * @property string $name
 * @property string $body
 * @property int $rating
 * @property string $image
 * @property string $created_at
 * @property int $user_id
 *
 * @property User $user
 */
class Obzor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obzor';
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
            [['rating'], 'integer'],
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
            'id' => 'ID',
            'name' => 'Название',
            'body' => 'Основной текст',
            'rating' => 'Рейтинг',
            'image' => 'Изображение',
            'created_at' => 'Created At',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('uploads/' . $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert && $this->user) {
            $this->user->updateRankByObzors();

            // Можно добавить уведомления прямо здесь
            $reviewCount = $this->user->getObzors()->count();
            if ($reviewCount == 1) {
                Yii::$app->session->setFlash('success', 'Вы получили статус "Активный участник"!');
            } elseif ($reviewCount == 3) {
                Yii::$app->session->setFlash('success', 'Поздравляем! Вы получили статус "Эксперт"!');
            }
        }
    }

    /**
     * Связь с пользователем
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
