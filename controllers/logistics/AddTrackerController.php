<?php

namespace app\controllers\logistics;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\logistics\AddTracker;

class AddTrackerController extends Controller
{
    public function actionIndex()
    {
        $model = new AddTracker();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // данные в $model удачно проверены

            // делаем что-то полезное с $model ...
            return $this->render('index', ['model' => $model]);
        } else {
            // либо страница отображается первый раз, либо есть ошибка в данных
            return $this->render('form-confirm', ['model' => $model]);
        }
    }
}
