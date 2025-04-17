<?php
namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    private static $users;

    // Константы рангов
    const RANK_NOVICE = 'Новичок';
    const RANK_ACTIVE = 'Активный участник';
    const RANK_EXPERT = 'Эксперт';

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return User::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * Связь с обзорами пользователя
     */

    /**
     * Обновляет ранг на основе количества обзоров
     */
    public function updateRankByObzors()
    {
        $obzorCount = $this->getObzors()->count();

        if ($obzorCount >= 3) {
            $this->rank = self::RANK_EXPERT;
            $this->addBadge('Эксперт');
        } elseif ($obzorCount >= 1) {
            $this->rank = self::RANK_ACTIVE;
        }

        $this->save(false);
    }

    /**
     * Добавляет значок пользователю
     */
    public function addBadge($badgeName)
    {
        $badges = $this->badges ? explode(',', $this->badges) : [];
        if (!in_array($badgeName, $badges)) {
            $badges[] = $badgeName;
            $this->badges = implode(',', $badges);
            return true;
        }
        return false;
    }

    /**
     * Проверяет наличие значка у пользователя
     */
    public function hasBadge($badgeName)
    {
        return $this->badges && in_array($badgeName, explode(',', $this->badges));
    }

    /**
     * Обновляет ранг на основе постов (старая логика)
     */
    public function getObzors()
    {
        return $this->hasMany(Obzor::class, ['user_id' => 'id']);
    }

    /**
     * Проверяет, является ли пользователь администратором.
     *
     * @return bool
     */

}