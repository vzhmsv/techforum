<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$this->title = 'Профиль пользователя: ' . $user->username;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-page">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="profile-info">
        <div class="user-rank">
            <strong>Ранг:</strong>
            <span class="rank-badge <?= str_replace(' ', '-', $user->rank) ?>">
                <?= $user->rank ?>
            </span>

            <?php if ($user->hasBadge('Эксперт')): ?>
                <span class="expert-badge">★</span>
            <?php endif; ?>
        </div>

        <div class="user-stats">
            <h3>Статистика:</h3>
            <ul>
                <li>Обзоров создано: <?= $user->getObzors()->count() ?></li>
                <li>Предложений создано: <?= $user->post_count ?></li>
                <li>Дата регистрации: <?= Yii::$app->formatter->asDate($user->created_at) ?></li>
            </ul>
        </div>

        <?php if ($user->badges): ?>
            <div class="user-badges">
                <h3>Значки:</h3>
                <div class="badges-list" style="color: #000000">
                    <?php foreach (explode(',', $user->badges) as $badge): ?>
                        <span class="badge" style="color:black "><?= trim($badge) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>