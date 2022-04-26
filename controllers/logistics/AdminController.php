<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;
use app\models\logistics\AddTrackerClient;
use yii\data\ActiveDataProvider;

class AdminController extends Controller
{
    public function actionAdminTrackerList()
    {
        if (Yii::$app->user->getId() != 6) {
            return $this->redirect(['/']);
        }
        $q = AddTrackerClient::find()->orderBy('id DESC');
        $model = AddTrackerClient::find()->all();
        $dataProvider = new ActiveDataProvider([
            'query' => $q,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('admin-tracker-list', [
            'dataProvider' => $dataProvider, 'model' => $model
        ]);
    }
}
