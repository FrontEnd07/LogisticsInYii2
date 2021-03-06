<?php

namespace app\controllers\logistics;

use Yii;
use app\models\User;
use yii\web\Controller;
use app\models\logistics\Address;
use app\models\logistics\AddTrackerClient;
use app\models\logistics\AdminTracker;
use yii\httpclient\Client;
use yii\data\ActiveDataProvider;

class AdminController extends Controller
{
    public function actionAdminTrackerList()
    {
        if (Yii::$app->user->getId() != 6) {
            return $this->redirect(['/']);
        }
        $filter = [];
        if (Yii::$app->request->get("user_name")) {
            $user = AddTrackerClient::find()->where(["name" => trim(Yii::$app->request->get("user_name"))])->one();
            if ($user) {
                $filter = ["id_client" => $user->id_client];
            }
        }


        $q = AddTrackerClient::find();

        if (count($filter) > 0) {
            $q->where($filter);
        }

        if (Yii::$app->request->get("from_date")) {
            $from_date = date_create(Yii::$app->request->get("from_date"));
            $to_date = date_create(Yii::$app->request->get("to_date"));
            $q->andHaving(['>=', 'date_time', strtotime('-1 days', date_format($from_date, 'U'))]);
            $q->andHaving(['<=', 'date_time', strtotime('+1 days', date_format($to_date, 'U'))]);
        }

        $track = [];
        foreach ($q->all() as $key => $value) {
            $track['list'][] = trim($value->tracker);
        }
        
        $client = new Client(['baseUrl' => 'https://351cargo.com/api/v1/']);
        $newUserResponse = $client->post('tracker/get-tracker', $track)->send();

        $adminTrackerList = new AdminTracker();
        $dataProvider = new ActiveDataProvider([
            'query' => $q,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => [Yii::$app->request->get("sort") => SORT_ASC]],
        ]);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('admin-tracker-list', [
            'dataProvider' => $dataProvider,
            'model' => $q->all(),
            'adminTrackerList' => $adminTrackerList,
            'resultApi' => $newUserResponse->data
        ]);
    }
    public function actionAdminPrint()
    {
        $this->layout = false;
        if (empty(Yii::$app->request->post("selection"))) {
            return $this->redirect(['/admin-tracker-list']);
        }
        $user = user::find()->where(['username' => trim(Yii::$app->request->post("AdminTracker")["username"])])->one();
        $address = Address::find()->where(['client' => $user->id])->one();
        $model = AddTrackerClient::find()->where(['in', 'id', Yii::$app->request->post("selection")])->all();
        $datePrint = Yii::$app->request->post("datePrint");

        return $this->render('admin-print', compact("user", "address", 'model', "datePrint"));
    }
}
