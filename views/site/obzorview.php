
<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $proposal \app\models\Proposal */

$this->title = $obzor->name;
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
        <?php if ($obzor->image): ?>
            <img src="../uploads/<?= Html::encode($obzor->image) ?>" class="card-img-top" alt="<?= Html::encode($obzor->name) ?>">
        <?php endif; ?>
        <div class="card-body">
            <!-- Текст -->
            <p class="card-text"><?= Html::encode($obzor->body) ?></p>
            <!-- Дата -->
            <p class="card-text"><small class="text-muted"><?= Yii::$app->formatter->asDatetime($obzor->created_at) ?></small></p>
        </div>


    <!-- Кнопка "Назад" -->
    <div class="mt-3">
        <a href="<?= Yii::$app->request->referrer ?: ['index'] ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>