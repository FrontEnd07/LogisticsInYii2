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
                        $boll = false;
                        foreach ($resultApi as $k => $value) {
                            if ($data->tracker == $value->track) {
                                $boll = $value->name;
                            }
                        }
                        if ($boll) {
                            return $boll;
                        } else {
                            return "Нет информации";
                        }
                    },
                    'format' => "text",
                    'label' => 'Вес посылки',
                ],
                [
                    'value' => function ($data) use ($resultApi, $resultApiMao) {
                        $boll = false;
                        foreach ($resultApi as $k => $value) {
                            if ($data->tracker == $value->track) {
                                $boll = true;
                            }
                        }
                        $infoApi = false;
                        if ($resultApiMao['data'] != "tracker empty") {
                            foreach ($resultApiMao['data'] as $k => $value) {
                                if (array_search($data->tracker, array_values($resultApiMao['data'][$k]), true)) {
                                    $infoApi = true;
                                }
                            }
                        }
                        if ($boll) {
                            return "Получен в Алмате";
                        } else {
                            if ($infoApi) {
                                return "Получен в китае";
                            }
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
                                'delete-tracker?id=' . $model->id
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
    </div>
</section>