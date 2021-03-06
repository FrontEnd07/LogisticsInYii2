<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\Home;
use app\models\logistics\Tracker;
use app\models\logistics\AddProgress;
use app\models\logistics\TrackerOtherSite;
use yii\httpclient\Client;

class HomeController extends Controller
{
    public function actionIndex()
    {
        $model = new Home();
        $request = Yii::$app->request;
        if ($request->post()) {
            $track = Tracker::find()
                ->where(['track' => trim($request->post('Home')['tracker'])])->one();
            $progress = AddProgress::find()->where(["id_tracker" => $track->id])->all();
            if ($track) $track->date_time = Yii::$app->formatter->asDate($track->date_time, 'dd MMMM, yyyy');
            if ($progress) {
                foreach ($progress as $key => $value) {
                    $progress[$key]['date'] = Yii::$app->formatter->asDate($value->date, 'dd MMMM, yyyy');
                }
            }
            return $this->render('index', ["model" => $model, "list" => $track, "progress" => $progress, $track ? "" : "error" => "false"]);
        }

        return $this->render('index', ["model" => $model]);
    }

    public function actionIndexApi()
    {
        $client = new Client(['baseUrl' => 'https://351cargo.com/api/v1/']);
        $model = new Home();
        if (Yii::$app->request->post()) {
            $newUserResponse = $client->post('tracker/get-tracker', ['list[]' => trim(Yii::$app->request->post('Home')['tracker'])])->send();
            if ($newUserResponse->data['status'] == "true") {
                $track = TrackerOtherSite::find()->where(["track" => trim(Yii::$app->request->post('Home')['tracker'])])->one();
                return $this->render('index-api', ["model" => $model, "track" => $track, "list" => $newUserResponse->data['data'][0], "progress" => $newUserResponse->data['progress']]);
            } else {
                return $this->render('index-api', ["model" => $model, "error" => 'false']);
            }
        }
        return $this->render('index-api', ["model" => $model]);
    }
}
