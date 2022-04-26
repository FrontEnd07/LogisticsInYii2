<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Регистрация';
?>
<section class="w-100 p-4 d-flex justify-content-center pb-4">
    <?php $form = ActiveForm::begin(['options' => ['style' => 'width:22rem;', "class" => "formCustom"]]) ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group">
        <div>
            <?= Html::submitButton('Регистрация', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</section>