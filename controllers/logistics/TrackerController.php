<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\Tracker;
use yii\data\ActiveDataProvider;

class TrackerController extends Controller
{
    public function actionAddTracker()
    {
        $model = new Tracker();
        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->request->get('id') && $model->validate()) {
                $tracker = explode(" ", trim($model->tracker));
                foreach ($tracker as $value) {
                    $arr[] = [$model->username, $model->location, time(), $value];
                }
                Yii::$app->db->createCommand()->batchInsert($model->tableName(), ['name', 'city', 'date_time', 'track'], $arr)->execute();
            }
            if (Yii::$app->request->get('id') && $model->validate()) {
                $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker], ['id' => Yii::$app->request->get('id')]);
            }
            $this->redirect("tracker");
        }

        if (Yii::$app->request->get('id')) {
            $model = $model->find()->where(['id' => Yii::$app->request->get('id')])->one();
            $model->username = $model->name;
            $model->location = $model->city;
            $model->tracker = $model->track;
        }
        return $this->render('add-tracker', ['model' => $model]);
    }
    public function actionTracker()
    {
        $q = Tracker::find()->orderBy('id DESC');
        $model = Tracker::find()->orderBy('id DESC')->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $q,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('tracker', [
            'dataProvider' => $dataProvider, 'model' => $model
        ]);
    }
    public function actionDeleteTracker()
    {
        Tracker::find()->where(['id' => Yii::$app->request->get('id')])->one()->delete();
        $this->redirect(Yii::$app->request->referrer);
    }
}
