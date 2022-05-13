<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->registerCssFile("/web/css/home.css");
$this->title = 'Мои посылки';
?>
<section>
    <div class="site-login tracker">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'options' => [
                'style' => 'overflow: auto;',
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'id',
                    'format' => 'text',
                    'label' => 'ID',
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
                    'format' => 'raw',
                    'label' => 'Наименования',
                ],
                [
                    'attribute' => 'date_time',
                    'format' => ['date', 'php:d/m/yy H:i'],
                    'label' => 'Время записи',
                ],
                [
                    'value' => function ($data) use ($resultApi) {
                        if ($resultApi['data'] != "tracker empty") {
                            $boll = false;
                            foreach ($resultApi['data'] as $k => $value) {
                                if (array_search($data->tracker, array_values($resultApi['data'][$k]), true)) {
                                    $boll = true;
                                }
                            }

                            if ($boll) {
                                return "Получен в китае";
                            } else {
                                return "Не доставлено";
                            }
                        } else {
                            return "Не доставлено";
                        }
                    },
                    'format' => "text",
                    'label' => 'Статус',
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