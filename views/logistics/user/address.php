<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Ваш адрес';
?>
<section class="w-100 p-4 d-flex justify-content-center pb-4">
    <?php $form = ActiveForm::begin(['options' => ['style' => 'width:44rem;', "class" => "formCustom"]]) ?>

    <? if ($status["update"]) : ?>
        <div class="alert alert-info" role="alert">
            Данные обновлены!
        </div>
    <? endif ?>
    <? if ($status["save"]) : ?>
        <div class="alert alert-success" role="alert">
            Данные добавленый!
        </div>
    <? endif ?>

    <?= $form->field($model, 'contry', ['options' => ['class' => 'form-outline mb-4']])->dropDownList([
        '0' => 'Россия',
        '1' => 'Казахстан',
    ]); ?>
    <?= $form->field($model, 'surname', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'name', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'region', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'city', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'house', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'postcode', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'phone', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <div class="form-group d-md-flex">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end() ?>
</section>