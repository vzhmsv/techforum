<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm; // Добавьте эту строку

/* @var $this yii\web\View */
/* @var $topic app\models\Topic */
/* @var $messages app\models\Message[] */
/* @var $messageModel app\models\Message */

$this->title = $topic->title;
?>
<div class="forum-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::encode($topic->description) ?></p>

    <h2>Сообщения</h2>

    <?php foreach ($messages as $message): ?>
        <div class="message">
            <p><strong><?= Html::encode($message->user->username) ?></strong> (<?= Yii::$app->formatter->asDatetime($message->created_at) ?>):</p>
            <p><?= Html::encode($message->content) ?></p>
        </div>
    <?php endforeach; ?>

    <h3>Добавить сообщение</h3>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($messageModel, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>