<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

$this->registerCssFile("/web/css/timeline.css");
$this->registerCssFile("/web/css/home.css");
$this->title = 'Logistics';
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'tracker')->label("Ваш трекер!") ?>
            <div class="form-group">
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
        <?php if ($list) : ?>
            <div class="col-md-12">
                <h4>Местоположения</h4>
                <ul class="timeline">
                    <li>
                        <span><?= $list->city ?></span>
                        <span class="float-right"><?= $list->date_time ?></span>
                        <p><?= $list->name ?> <?= $list->track ?></p>
                    </li>
                </ul>
            </div>
        <?php endif ?>
    </div>
</div>