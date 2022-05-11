<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Ваш адрес';
?>
<section>
    <?php $form = ActiveForm::begin(['options' => ["class" => "formCustom"]]) ?>

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