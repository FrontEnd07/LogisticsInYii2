<?php

namespace app\controllers\logistics;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;


class HomeController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
