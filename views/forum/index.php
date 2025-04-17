<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Форум обсуждений';
?>
<div class="forum-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать тему', ['create-topic'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="row">
        <?php foreach ($dataProvider->getModels() as $topic): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <!-- Название темы -->
                        <h5 class="card-title"><?= Html::encode($topic->title) ?></h5>
                        <!-- Описание темы -->
                        <p class="card-text"><?= Html::encode($topic->description) ?></p>
                        <!-- Автор темы -->
                        <p class="card-text">
                            <small class="text-muted">
                                Создал: <?= Html::encode($topic->user->username) ?>
                            </small>
                        </p>
                        <!-- Дата создания -->
                        <p class="card-text">
                            <small class="text-muted">
                                <?= Yii::$app->formatter->asDatetime($topic->created_at) ?>
                            </small>
                        </p>
                    </div>
                    <div class="card-footer">
                        <!-- Кнопка "Просмотреть" -->
                        <a href="<?= Url::to(['view', 'id' => $topic->id]) ?>" class="btn btn-primary">
                            Просмотреть
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>