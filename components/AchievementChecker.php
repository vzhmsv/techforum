<?php

namespace app\components;

use Yii;
use app\models\User;

class AchievementChecker extends \yii\base\Component
{
    public function checkReviewAchievements(User $user)
    {
        $reviewCount = $user->getReviews()->count();

        // Активный участник за 1 обзор
        if ($reviewCount >= 1 && $user->rank !== User::RANK_ACTIVE) {
            $user->rank = User::RANK_ACTIVE;
            $user->save(false);
            Yii::$app->session->setFlash('success', 'Вы получили ранг "Активный участник"!');
        }

        // Эксперт за 3 обзора
        if ($reviewCount >= 3 && !$user->hasBadge('Эксперт')) {
            $user->addBadge('Эксперт');
            Yii::$app->session->setFlash('success', 'Поздравляем! Вы получили ранг "Эксперт"!');
        }
    }
}