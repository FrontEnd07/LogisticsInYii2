<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Настройка акаунта';
?>

<section class="w-100 p-4 d-flex justify-content-center pb-4">
    <?php $form = ActiveForm::begin(['options' => ['style' => 'width:22rem;', "class" => "formCustom"]]) ?>
    <?= $form->field($model, 'username', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'email', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'password', ['options' => ['class' => 'form-outline mb-4']])->passwordInput() ?>
    <div class="form-group">
        <div>
            <?= Html::submitButton('Изменить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</section>