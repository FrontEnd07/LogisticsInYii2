<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\logistics\AddTracker $model */

use yii\bootstrap4\ActiveForm;
// use yii\bootstrap4\Html;
use yii\helpers\Html;

$this->title = 'Добавить трекер';
?>
<div class="site-login">
    <h1>Добавить трекер:</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->label("Ваше имя!") ?>

    <?= $form->field($model, 'tracker')->textarea()->label("укажите трекеры!") ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>