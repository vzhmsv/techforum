<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $proposal array */

$this->title = 'Главная страница';
?>

<!-- Стили для карточек -->
<style>
    .card-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px; /* Расстояние между карточками */
        justify-content: flex-start; /* Выравнивание карточек по левому краю */
    }
    .card {
        flex: 1 1 calc(33.333% - 20px); /* Три карточки в ряд с отступами */
        max-width: calc(33.333% - 20px); /* Максимальная ширина карточки */
        box-sizing: border-box; /* Учитываем padding и border в ширине */
        display: flex;
        flex-direction: column;
        border: 1px solid #ddd; /* Граница карточки */
        border-radius: 8px; /* Закруглённые углы */
        overflow: hidden; /* Обрезаем содержимое, чтобы не выходило за границы */
    }
    .card-img-top {
        width: 100%; /* Ширина изображения на всю ширину карточки */
        height: 200px; /* Фиксированная высота */
        object-fit: cover; /* Обрезка изображения для сохранения пропорций */
    }
    .card-body {
        padding: 15px; /* Отступы внутри карточки */
        flex-grow: 1; /* Растягиваем тело карточки, чтобы кнопка была внизу */
        display: flex;
        flex-direction: column;
    }
    .card-title {
        font-size: 1.25rem; /* Размер заголовка */
        margin-bottom: 10px; /* Отступ снизу */
    }
    .card-text {
        flex-grow: 1; /* Растягиваем текст, чтобы кнопка была внизу */
        margin-bottom: 10px; /* Отступ снизу */
    }
    .card-text small {
        color: #6c757d; /* Цвет для даты */
    }
    .btn-primary {
        align-self: flex-start; /* Выравниваем кнопку по левому краю */
    }
</style>
<hr>
<h1 style="text-align: center">Новости</h1>
<!-- Вывод карточек с заявками -->
<hr>
<div class="card-container">
    <?php foreach ($proposal as $item): ?>
        <div class="card">
            <!-- Изображение -->
            <img src="uploads/<?= Html::encode($item['image']) ?>" class="card-img-top" alt="<?= Html::encode($item['name']) ?>">
            <!-- Текст, который выдвигается при наведении -->
            <div class="card-body">
                <!-- Название -->
                <h5 class="card-title"><?= Html::encode($item['name']) ?></h5>
                <!-- Текст с ограничением длины -->
                <p class="card-text"><?= mb_substr(Html::encode($item['body']), 0, 100) ?>...</p>
                <!-- Дата -->
                <p class="card-text"><small><?= Html::encode($item['created_at']) ?></small></p>
                <!-- Кнопка "Подробнее" -->
                <a href="<?= \yii\helpers\Url::to(['site/view', 'id' => $item['id']]) ?>" class="btn btn-primary">Подробнее</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<hr>
<h1 style="text-align: center">Обзоры</h1>
<hr>

<div class="card-container">
    <?php foreach ($obzor as $item): ?>
        <div class="card">
            <!-- Изображение -->
            <img src="uploads/<?= Html::encode($item['image']) ?>" class="card-img-top" alt="<?= Html::encode($item['name']) ?>">
            <div class="card-body">
                <!-- Название -->
                <h5 class="card-title"><?= Html::encode($item['name']) ?></h5>
                <!-- Текст с ограничением длины -->
                <p class="card-text"><?= mb_substr(Html::encode($item['body']), 0, 100) ?>...</p>
                <!-- Дата -->
                <p class="card-text"><small><?= Html::encode($item['rating']) ?></small></p>
                <p class="card-text"><small><?= Html::encode($item['created_at']) ?></small></p>
                <!-- Кнопка "Подробнее" -->
                <a href="<?= \yii\helpers\Url::to(['site/obzorview', 'id' => $item['id']]) ?>" class="btn btn-primary">Подробнее</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>