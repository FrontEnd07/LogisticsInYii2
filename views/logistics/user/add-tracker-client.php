<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Добавить трекер!';
?>
<section class="">
    <?php $form = ActiveForm::begin([
        'options' => ["class" => "formCustom"],
    ]) ?>

    <?php if (isset($status["update"])) : ?>
        <div class="alert alert-info" role="alert">
            Данные обновлены!
        </div>
    <?php endif ?>
    <?php if (isset($status["save"])) : ?>
        <div class="alert alert-success" role="alert">
            Данные добавленый!
        </div>
    <?php endif ?>

    <?= $form->field($model, 'tracker', ['options' => [
        'class' => 'mb-4',
    ]])->textInput() ?>
    <?= $form->field($model, 'name', [
        'options' => ['class' => 'mb-4'],
    ])->textInput() ?>
    <?= $form->field($model, 'nameItem', [
        'options' => ['class' => 'mb-4']
    ])->textInput() ?>
    <?= $form->field($model, 'quantity', [
        'options' => ['class' => 'mb-4']
    ])->textInput() ?>
    <div class="form-group d-md-flex">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</section>