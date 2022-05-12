<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Все посылки на сайте';
?>

<section>
    <div class="site-login tracker">
        <?php $form = ActiveForm::begin(); ?>
        <div class="filter__block__admin row">
            <div class="col-md-6 col-sm-12">
                <label class="control-label" for="from_date">Фильтр по дате</label>
                <?= DatePicker::widget(
                    [
                        'name' => 'from_date',
                        'value' => date("M d, Y", strtotime('-10 days')),
                        'type' => DatePicker::TYPE_RANGE,
                        'options' => ['style' => 'width:130px', "class" => "", "id" => "from_date"],
                        'name2' => 'to_date',
                        'value2' => date("M d, Y"),
                        'options2' => ['style' => 'width:130px', "class" => ""],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'M dd, yyyy',
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <label class="control-label" for="user_name">Имя</label>
                <input type="text" id="user_name" class="form-control" name="user_name">
            </div>
            <div class="col-sm-12" style="margin-top: 10px;">
                <?= Html::submitButton('Фильтр', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <?php $form = ActiveForm::begin(['action' => 'logistics/admin/admin-print']); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'style' => 'overflow: auto;',
            ],
            'columns' => [
                ['class' => 'yii\grid\CheckboxColumn'],
                [
                    'class' => 'yii\grid\SerialColumn',
                ],
                [
                    'attribute' => 'tracker',
                    'format' => 'raw',
                    'value' =>  function ($data) {
                        return  Html::a(
                            $data->tracker,
                            ['/'],
                            [
                                'title' => $data->tracker,
                                'data' => [
                                    'method' => 'post',
                                    'params' => [
                                        'Home[tracker]' => $data->tracker,
                                    ],
                                ],
                            ]
                        );
                    },
                    'label' => 'Трекеры',
                ],
                [
                    'attribute' => 'nameItem',
                    'format' => 'text',
                    'label' => 'Наименования',
                ],
                [
                    'attribute' => 'date_time',
                    'format' => ['date', 'php:d/m/yy H:i'],
                    'label' => 'Время записи',
                ],
                [
                    'attribute' => 'name',
                    'format' => "text",
                    'label' => 'Клиент',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'header' => 'Действия',
                    'headerOptions' => ['width' => '80'],
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            return Html::a(
                                '<i class="fa fa-trash" aria-hidden="true"></i>',
                                'delete?id=' . $model->id
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <label class="form-label">Дата печати</label>
                <?= DatePicker::widget([
                    'name' => 'datePrint',
                    'type' => DatePicker::TYPE_INPUT,
                    'value' => date("M d, Y"),
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'M dd, yyyy'
                    ]
                ]); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <?= $form->field($adminTrackerList, 'username') ?>
            </div>
            <div class="col-sm-12">
                <?= Html::submitButton('Печатать', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>