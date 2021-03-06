<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->registerCssFile("/web/css/tracker.css");
$this->title = 'Трекеры';
?>
<div class="site-login">
    <h1>Список посылок</h1>

    <a class="btn btn-success" style="margin-bottom:10px" href=<?= Yii::$app->urlManager->createUrl(['logistics/tracker/add-tracker-other-site']); ?>>Добавить</a>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'track',
                'format' => 'raw',
                'value' =>  function ($data) {
                    return  Html::a(
                        $data->track,
                        'add-tracker-other-site?id=' . $data->id,
                        [
                            'title' => $data->track,
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
                'format' => "raw",
                'label' => 'Вес посылки',
            ],
            // [
            //     'value' => function ($data) use ($resultApi) {
            //         if ($resultApi['data'] != "tracker empty") {
            //             $boll = false;
            //             foreach ($resultApi['data'] as $k => $value) {
            //                 if (array_search($data->track, array_values($resultApi['data'][$k]), true)) {
            //                     $boll = true;
            //                 }
            //             }

            //             if ($boll) {
            //                 return "Получен в китае";
            //             } else {
            //                 return "Не доставлено";
            //             }
            //         } else {
            //             return "Не доставлено";
            //         }
            //     },
            //     'format' => "text",
            //     'label' => 'Статус',
            // ],
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