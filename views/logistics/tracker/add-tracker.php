<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\logistics\AddTracker $model */

use yii\bootstrap4\ActiveForm;
// use yii\bootstrap4\Html;
use yii\helpers\Html;

$this->registerCssFile("/web/css/tracker.css");
$this->title = 'Добавить трекер';
?>
<div class="site-login">
    <h1>Добавить трекер:</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->label("Ваше имя!") ?>

    <?= $form->field($model, 'location')->label("Город получателя!") ?>

    <?= $form->field($model, 'tracker')->textarea(['placeholder' => "Например: YT4632112889989"])->label("Укажите трекеры!") ?>
    <?= $form->field($model, 'position')->label(false)->dropDownList([
        '0' => 'Получен на склад',
        '1' => 'Товар в Алмате',
        '2' => 'Товар в Москве'
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
        <a class="btn btn-warning" style="margin-left:10px" href=<?= Yii::$app->urlManager->createUrl(['tracker']); ?>>Назад</a>
    </div>

    <?php ActiveForm::end(); ?>
</div>