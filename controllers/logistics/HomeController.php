<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\Home;
use app\models\logistics\Tracker;


class HomeController extends Controller
{
    public function actionIndex()
    {
        $model = new Home();
        $request = Yii::$app->request;
        if ($request->post()) {
            $track = Tracker::find()
                ->where(['track' => trim($request->post('Home')['tracker'])])->one();
            if ($track) $track->date_time = Yii::$app->formatter->asDate($track->date_time, 'dd MMMM, yyyy H:i');
        }
        return $this->render('index', ["model" => $model, "list" => $track]);
    }
}
