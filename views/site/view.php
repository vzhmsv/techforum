<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $proposal \app\models\Proposal */

$this->title = $proposal->name;
?>
<style>
    .card-img-top {
        width: 450px; /* Ширина на всю ширину карточки */
        height: 450px; /* Фиксированная высота */
        object-fit: cover; /* Обрезка изображения для сохранения пропорций */
    }
</style>
<div class="proposal-view">
    <h1><?= Html::encode($this->title) ?></h1>


        <!-- Изображение -->
        <?php if ($proposal->image): ?>
            <img src="../uploads/<?= Html::encode($proposal->image) ?>" class="card-img-top" alt="<?= Html::encode($proposal->name) ?>">
        <?php endif; ?>
        <div class="card-body">
            <!-- Текст -->
            <p class="card-text"><?= Html::encode($proposal->body) ?></p>
            <!-- Дата -->
            <p class="card-text"><small class="text-muted"><?= Yii::$app->formatter->asDatetime($proposal->created_at) ?></small></p>
        </div>


    <!-- Кнопка "Назад" -->
    <div class="mt-3">
        <a href="<?= Yii::$app->request->referrer ?: ['index'] ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>