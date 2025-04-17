<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;

$this->title = 'Написать обзор';

?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">

            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'body')->textArea() ?>

            <?= $form->field($model, 'rating')->dropDownList([
                1 => '1',
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
            ], ['prompt' => 'Выберите оценку']) ?>


            <?= $form->field($model, 'image')->fileInput() ?>



            <div class="form-group">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>


</div>
