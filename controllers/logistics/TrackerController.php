<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\Tracker;
use app\models\logistics\OcKuaidi;
use app\models\logistics\AddProgress;
use yii\data\ActiveDataProvider;

class TrackerController extends Controller
{
    public function actionAddTracker()
    {
        $model = new Tracker();
        $modelProgress = new AddProgress();
        if ($model->load(Yii::$app->request->post())) {
            $tracker = explode(PHP_EOL, trim($model->tracker));
            if (!Yii::$app->request->get('id') && $model->validate() && $model->position == 0) {
                foreach ($tracker as $value) {
                    $arr[] = [$model->username, $model->location, time(), $value, 0];
                }
                Yii::$app->db->createCommand()->batchInsert($model->tableName(), ['name', 'city', 'date_time', 'track', "status"], $arr)->execute();
            }
            if (!Yii::$app->request->get('id') && $model->position == 1 && $model->validate()) {
                foreach ($tracker as $value) {
                    $id = $model->find()->where(['track' => $value])->select('id')->one()["id"];
                    $arr[] = [$id, "Товар в Алмате", time()];
                }
                Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
            }
            if (!Yii::$app->request->get('id') && $model->position == 2 && $model->validate()) {
                foreach ($tracker as $value) {
                    $id = $model->find()->where(['track' => $value])->select('id')->one()["id"];
                    $arr[] = [$id, "Товар в Москве", time()];
                }
                Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
            }
            if (Yii::$app->request->get('id') && $model->validate()) {
                $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker], ['id' => Yii::$app->request->get('id')]);
            }
            $this->redirect("/");
        }
        $model->username = "Работник";
        $model->location = "China, Guangdong, Guangzhou";
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

    public function actionAddProgress()
    {
        set_time_limit(120);
        $model = new Tracker();
        $modelProgress = new AddProgress();
        $status = array();
        foreach ($model->find()->where(["status" => 0])->limit(2000)->all() as $value) {
            if (!$value->status) {
                $count = $modelProgress->find()->where(["id_tracker" => $value->id])->count();
                if ($count > 0 && $count != 5) {
                    $date = $modelProgress->find()->where(["id_tracker" => $value->id])->orderBy(['id' => SORT_DESC])->select(["date"])->one()['date'];
                }
                if ($count == 0 && time() >= strtotime('+1 day', $value->date_time)) {
                    $arr[] = [$value->id, "Покинуло сортировочный центр", strtotime('+1 day', $value->date_time)];
                }
                if ($count == 1 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Ожидайте ваш товар через 3 дня будеть на границе", strtotime('+1 day', $date)];
                }
                if ($count == 2 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Не беспокойтесь ваш товар будет на границе через 2 дня", strtotime('+1 day', $date)];
                }
                if ($count == 3 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Мы проверяем вашу посылку каждый день ваша посылка завтра уже будет на границе", strtotime('+1 day', $date)];
                }
                if ($count == 4 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Товар находится на границе", strtotime('+1 day', $date)];
                }
                if ($count == 5) {
                    $status[] = $value->id;
                }
            }
        }
        if (count($status) > 0) {
            $model->updateAll(['status' => 1], ['id' => $status]);
        }
        Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
        die;
    }

    public function actionImport()
    {
        $model = OcKuaidi::find()->all();
        foreach ($model as $value) {
            $dateTime = new \DateTime($value->date);
            $arr[] = [$value->name_user, $value->location, $dateTime->format('U'), $value->tracker];
        }
        Yii::$app->db->createCommand()->batchInsert("tracker", ['name', 'city', 'date_time', 'track'], $arr)->execute();
    }
}
