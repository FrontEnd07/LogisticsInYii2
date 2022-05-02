<?php

namespace app\controllers\api\v1;

use Yii;
use app\models\logistics\AddProgress;
use app\models\logistics\Tracker;
use yii\rest\ActiveController;


class TrackerController extends ActiveController
{

    public $modelClass = 'app\models\logistics\Home';

    public function actionGetTracker()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Tracker::find()->where(['in', 'track', Yii::$app->request->post("list")])->all();
        $progress = AddProgress::find()->where(['in', 'id_tracker', Yii::$app->request->post("list")])->all();
        if ($progress) {
            foreach ($progress as $key => $value) {
                $progress[$key]['date'] = Yii::$app->formatter->asDate($value->date, 'dd MMMM, yyyy');
            }
        }
        if (count($model) > 0) {
            return array('status' => true, 'data' => $model);
        } else {
            return array('status' => false, 'data' => "tracker empty");
        }
    }
}
