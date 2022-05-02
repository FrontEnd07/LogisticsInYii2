<?php

use yii\grid\GridView;
use yii\helpers\Html;
use kartik\date\DatePicker;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Все посылки на сайте';
?>
<section class="w-100 p-4 justify-content-center pb-4">
    <div class="site-login tracker">
        <div class="flter__list">


            <div style="width: 300px;">
                <label class="form-label">Сортировка по дате</label>
                <?= DatePicker::widget([
                    'name' => 'from_date',
                    'value' => date("M j, Y", strtotime("-10 day")),
                    'type' => DatePicker::TYPE_RANGE,
                    'name2' => 'to_date',
                    'value2' => date("M j, Y"),
                    'pluginOptions' => [
                        'autoclose' => true,
                        'format' => 'M dd, yyyy'
                    ]
                ]); ?>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'format' => 'text',
                    'label' => 'ID',
                ],
                [
                    'attribute' => 'asdS',
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
                    'label' => 'Заголовок',
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
    </div>
</section>