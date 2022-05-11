<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Настройка акаунта';
?>

<section>
    <?php $form = ActiveForm::begin(['options' => ["class" => "formCustom"]]) ?>
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