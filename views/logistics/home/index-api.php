<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->registerCssFile("/web/css/timeline.css");
$this->registerCssFile("/web/css/home.css");
$this->title = 'Logistics';
?>

<section>
    <div class="tracker">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'tracker')->label("Ваш трекер!") ?>
        <div class="form-group">
            <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert" style="margin-bottom:0px">
                Данный трекер не существует!
            </div>
        <?php endif ?>
        <?php if (isset($list)) : ?>
            <div class="col-md-12">
                <h4>Местоположения</h4>
                <ul class="timeline">
                    <li>
                        <span><?= $list['city'] ?></span>
                        <span class="float-right"><?= Yii::$app->formatter->asDate($list['date_time'], 'dd MMMM, yyyy') ?></span>
                        <p><?= $list['track'] ?>: Принято в отделении связи</p>
                    </li>
                    <?php if ($progress) : ?>
                        <?php foreach ($progress as $value) : ?>
                            <li>
                                <span>
                                    <?php if ($value['text'] == "Товар в Алмате") : ?>
                                        Kazakhstan
                                    <?php elseif ($value['text'] == "Товар в Москве") : ?>
                                        Russia
                                    <?php else : ?>
                                        China
                                    <?php endif; ?>
                                </span>
                                <span class="float-right"><?= $value['date'] ?></span>
                                <p><?= $list['track'] ?>: <?= $value['text'] ?></p>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif ?>
    </div>
</section>