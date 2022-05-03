<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\AddTrackerClient;
use app\models\logistics\AdminTracker;
use app\models\User;
use yii\data\ActiveDataProvider;

class AdminController extends Controller
{
    public function actionAdminTrackerList()
    {
        if (Yii::$app->user->getId() != 6) {
            return $this->redirect(['/']);
        }

        if (Yii::$app->request->post("user_name")) {
            $user = User::find()->where(["username" => trim(Yii::$app->request->post("user_name"))])->one();
            $filter = ["id_client" => $user->id];
        }


        $q = AddTrackerClient::find();

        if ($filter) {
            $q->where($filter);
        }
        if (Yii::$app->request->post("from_date")) {
            $from_date = date_create(Yii::$app->request->post("from_date"));
            $to_date = date_create(Yii::$app->request->post("to_date"));
            $q->andHaving(['>=', 'date_time', date_format($from_date, 'U')]);
            $q->andHaving(['<=', 'date_time', date_format($to_date, 'U')]);
        }

        $model = AddTrackerClient::find()->all();
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
            'dataProvider' => $dataProvider, 'model' => $model, 'adminTrackerList' => $adminTrackerList
        ]);
    }
    public function actionAdminPrint()
    {
        if (empty(Yii::$app->request->post("selection"))) {
            return $this->redirect(['/admin-tracker-list']);
        }

        $model = AddTrackerClient::find()->where(['in', 'id', Yii::$app->request->post("selection")])->all();
        foreach ($model as $key => $value) {
            echo $value->tracker . "<br />";
        }
        die();
    }
}
