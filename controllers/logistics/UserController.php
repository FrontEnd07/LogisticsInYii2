<?php

namespace app\controllers\logistics;


use Yii;
use app\models\logistics\Address;
use yii\web\Controller;
use app\models\logistics\SignupForm;
use app\models\logistics\SignIn;

class UserController extends Controller
{
    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->signUp()) {
                return $this->goHome();
            }
        }

        return $this->render('signup', compact('model'));
    }
    public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new SignIn();

        if (\Yii::$app->request->post("SignIn")) {
            $model->attributes = \Yii::$app->request->post("SignIn");
            if ($model->validate()) {
                Yii::$app->user->login($model->getUser(), $model->rememberMe ? 3600 * 24 * 30 : 0);
                return  $this->goHome();
            }
        }
        return $this->render('signin', compact('model'));
    }
    public function actionAddress()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Address();
        // $user = $model->find()->where(["id" => Yii::$app->user->getId()])->one();
        // die();
        if (Yii::$app->request->post("Address")) {
            $model->attributes = Yii::$app->request->post("Address");
        }
        return $this->render('address', compact('model'));
    }
}
