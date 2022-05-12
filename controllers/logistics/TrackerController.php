<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\Tracker;
use app\models\logistics\OcKuaidi;
use app\models\logistics\AddProgress;
use app\models\logistics\TrackerOtherSite;
use yii\data\ActiveDataProvider;
use yii\httpclient\Client;

class TrackerController extends Controller
{
    public function actionAddTracker()
    {
        if (Yii::$app->user->getId() != 6 and Yii::$app->user->getId() != 10) {
            return $this->redirect(['/']);
        }
        $model = new Tracker();
        $modelProgress = new AddProgress();
        if ($model->load(Yii::$app->request->post())) {
            $tracker = explode(PHP_EOL, trim($model->tracker));
            if (!Yii::$app->request->get('id') && $model->validate() && $model->position == 0) {
                foreach ($tracker as $value) {
                    $arr[] = [$model->username, $model->location, time(), trim($value), 0];
                }
                Yii::$app->db->createCommand()->batchInsert($model->tableName(), ['name', 'city', 'date_time', 'track', "status"], $arr)->execute();
            }
            if (!Yii::$app->request->get('id') && $model->position == 1 && $model->validate()) {
                foreach ($tracker as $value) {
                    $id = $model->find()->where(['track' => trim($value)])->select('id')->one()["id"];
                    $arr[] = [$id, "Товар покинул склад", time()];
                }
                Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
            }
            if (!Yii::$app->request->get('id') && $model->position == 2 && $model->validate()) {
                foreach ($tracker as $value) {
                    $id = $model->find()->where(['track' => trim($value)])->select('id')->one()["id"];
                    $arr[] = [$id, "Товар в Алмате", time()];
                }
                print_r($arr);
                die();
                Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
            }
            if (!Yii::$app->request->get('id') && $model->position == 3 && $model->validate()) {
                foreach ($tracker as $value) {
                    $id = $model->find()->where(['track' => trim($value)])->select('id')->one()["id"];
                    $arr[] = [$id, "Товар через 7 дней будеть в Москве", time()];
                }
                Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
            }
            if (Yii::$app->request->get('id') && $model->validate()) {
                switch ($model->position) {
                    case 0:
                        $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker], ['id' => Yii::$app->request->get('id')]);
                        break;
                    case 1:
                        foreach ($tracker as $value) {
                            $id = $model->find()->where(['track' => trim($value)])->select('id')->one()["id"];
                            $arr[] = [$id, "Товар покинул склад", time()];
                        }
                        Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
                        break;
                    case 2:
                        foreach ($tracker as $value) {
                            $id = $model->find()->where(['track' => trim($value)])->select('id')->one()["id"];
                            $arr[] = [$id, "Товар в Алмате", time()];
                        }
                        Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
                        break;
                    case 3:
                        foreach ($tracker as $value) {
                            $id = $model->find()->where(['track' => trim($value)])->select('id')->one()["id"];
                            $arr[] = [$id, "Товар через 7 дней будеть в Москве", time()];
                        }
                        Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
                        break;
                }
            }
            $this->redirect("/");
        }
        $model->username = "0";
        $model->location = "China, Guangdong, Guangzhou";
        if (Yii::$app->request->get('id')) {
            $model = $model->find()->where(['id' => Yii::$app->request->get('id')])->one();
            $model->username = $model->name;
            $model->location = $model->city;
            $model->tracker = $model->track;
        }
        return $this->render('add-tracker', ['model' => $model]);
    }

    public function actionAddTrackerOtherSite()
    {
        if (Yii::$app->user->getId() != 6 and Yii::$app->user->getId() != 10) {
            return $this->redirect(['/']);
        }
        $model = new TrackerOtherSite();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $tracker = explode(PHP_EOL, trim($model->tracker));
            if (!Yii::$app->request->get('id')) {
                switch ($model->position) {
                    case 0:
                        foreach ($tracker as $value) {
                            $arr[] = [$model->username, $model->location, time(), trim($value), "Получен на склад"];
                        }
                        break;
                    case 1:
                        foreach ($tracker as $value) {
                            $arr[] = [$model->username, $model->location, time(), trim($value), "Товар отгружен"];
                        }
                        break;
                    case 2:
                        foreach ($tracker as $value) {
                            $arr[] = [$model->username, $model->location, time(), trim($value), "Товар в Алмате"];
                        }
                        break;
                    case 3:
                        foreach ($tracker as $value) {
                            $arr[] = [$model->username, $model->location, time(), trim($value), "Товар в Москве"];
                        }
                        break;
                }
                Yii::$app->db->createCommand()->batchInsert($model->tableName(), ['name', 'city', 'date_time', 'track', "status"], $arr)->execute();
            } else {
                switch ($model->position) {
                    case 0:
                        $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker, "status" => "Получен на склад"], ['id' => Yii::$app->request->get('id')]);
                        break;
                    case 1:
                        $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker, "status" => "Товар отгружен"], ['id' => Yii::$app->request->get('id')]);
                        break;
                    case 2:
                        $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker, "status" => "Товар в Алмате"], ['id' => Yii::$app->request->get('id')]);
                        break;
                    case 3:
                        $model::updateAll(["name" => $model->username, "city" => $model->location, "date_time" => time(), "track" => $model->tracker, "status" => "Товар в Москве"], ['id' => Yii::$app->request->get('id')]);
                        break;
                }
            }
            $this->redirect("logistics/tracker/tracker");
        }
        $model->username = "0";
        $model->location = "China, Guangdong, Guangzhou";
        if (Yii::$app->request->get('id')) {
            $model = $model->find()->where(['id' => Yii::$app->request->get('id')])->one();
            $model->username = $model->name;
            $model->location = $model->city;
            $model->tracker = $model->track;
        }
        return $this->render('add-tracker-other-site', ['model' => $model]);
    }

    public function actionTracker()
    {
        if (Yii::$app->user->getId() != 6 and Yii::$app->user->getId() != 10) {
            return $this->redirect(['/']);
        }
        $q = TrackerOtherSite::find();
        $model = TrackerOtherSite::find()->all();
        $track = [];
        foreach ($model as $key => $value) {
            $track['list'][] = trim($value->track);
        }
        $client = new Client(['baseUrl' => 'https://351cargo.com/api/v1/']);
        $newUserResponse = $client->post('tracker/get-tracker', $track)->send();
        $dataProvider = new ActiveDataProvider([
            'query' => $q,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];
        return $this->render('tracker', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'resultApi' => $newUserResponse->data
        ]);
    }

    public function actionDeleteTracker()
    {
        if (Yii::$app->user->getId() != 102) {
            return $this->redirect(['/']);
        }
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
            $count = $modelProgress->find()->where(["id_tracker" => $value->id])->count();
            if ($count >= 1) {
                if ($count >= 1 && $count != 6) {
                    $date = $modelProgress->find()->where(["id_tracker" => $value->id])->orderBy(['id' => SORT_DESC])->select(["date"])->one()['date'];
                }
                if ($count == 1 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Товар через 4 дней будеть на границе", strtotime('+1 day', $date)];
                }
                if ($count == 2 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Ожидайте ваш товар через 3 дня будеть на границе", strtotime('+1 day', $date)];
                }
                if ($count == 3 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Не беспокойтесь ваш товар будет на границе через 2 дня", strtotime('+1 day', $date)];
                }
                if ($count == 4 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Мы проверяем вашу посылку каждый день ваша посылка завтра уже будет на границе", strtotime('+1 day', $date)];
                }
                if ($count == 5 && time() >= strtotime('+1 day', $date)) {
                    $arr[] = [$value->id, "Товар находится на границе", strtotime('+1 day', $date)];
                }
                if ($count == 6) {
                    $status[] = $value->id;
                }
            }
        }
        if (count($status) > 0) {
            $model->updateAll(['status' => 1], ['id' => $status]);
        }
        if ($arr) {
            Yii::$app->db->createCommand()->batchInsert($modelProgress->tableName(), ['id_tracker', 'text', 'date'], $arr)->execute();
        }
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
