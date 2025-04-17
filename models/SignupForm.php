<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $repeat_password
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $repeat_password;
    public $email;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'email','repeat_password'], 'required'],
            ['email', 'email'],
            ['repeat_password', 'compare', 'compareAttribute'=>'password'],
            [['username', 'password', 'email'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'repeat_password' => 'Повтор пароля',
            'email' => 'Email',
        ];
    }

    public function signup()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
        return $user->save();
    }
}
