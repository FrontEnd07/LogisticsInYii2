<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Авторизация';
?>

<section class="w-100 p-4 d-flex justify-content-center pb-4">
    <?php $form = ActiveForm::begin(['options' => ['style' => 'width:22rem;', "class" => "formCustom"]]) ?>
    <?= $form->field($model, 'email', ['options' => ['class' => 'form-outline mb-4']])->textInput() ?>
    <?= $form->field($model, 'password', ['options' => ['class' => 'form-outline mb-4']])->passwordInput() ?>
    <div class="form-group">
        <div>
            <?= Html::submitButton('Войти', ['class' => 'btn form-control btn btn-primary submit px-3']) ?>
        </div>
    </div>
    <div class="form-group d-md-flex">
        <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'w-50']])->checkbox(['template' => "<div class=\"w-50\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>"]) ?>
        <div class="w-50 text-md-right">
            <a href="<?= Yii::$app->urlManager->createUrl(['logistics/user/signup']) ?>">Регистрация</a>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</section>