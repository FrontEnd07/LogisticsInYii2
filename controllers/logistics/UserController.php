<?php

namespace app\controllers\logistics;

use Yii;
use yii\web\Controller;

use app\models\logistics\SignupForm;
use app\models\logistics\SignIn;
use app\models\User;



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

            // $user = new User();
            // $user->username = $model->username;
            // $user->password = \Yii::$app->security->generatePasswordHash($model->password);
            // $user->email = $model->email;
            // echo '<pre>';
            // print_r($user);
            // die;
            // if ($user->save()) {
            //     return $this->goHome();
            // }
        }

        return $this->render('signup', compact('model'));
    }
    public function actionSignin()
    {
        $model = new SignIn();

        if (\Yii::$app->request->post("SignIn")) {
            $model->attributes = \Yii::$app->request->post("SignIn");
            if ($model->validate()) {
                var_dump("Валидация");
                die();
            }
        }
        return $this->render('signin', compact('model'));
    }
}
