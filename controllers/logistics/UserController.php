<?php

namespace app\controllers\logistics;


use Yii;
use app\models\User;
use yii\web\Controller;
use app\models\logistics\Address;
use app\models\logistics\AddTrackerClient;
use app\models\logistics\ChangeAccount;
use app\models\logistics\SignupForm;
use app\models\logistics\SignIn;
use app\models\logistics\TrackerOtherSite;
use yii\data\ActiveDataProvider;
use yii\httpclient\Client;

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
                Yii::$app->response->redirect('signin');
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
            Yii::$app->response->redirect('signin');
        }

        $model = new Address();
        $user = $model->find()->where(["client" => Yii::$app->user->getId()])->one();
        $status = [];
        if (Yii::$app->request->post("Address") && $user) {
            $model->updateAll(Yii::$app->request->post("Address"), ["client" => Yii::$app->user->getId()]);
            $status["update"] = true;
        }

        if ($user) {
            $user = $model->find()->where(["client" => Yii::$app->user->getId()])->one();
            $model->contry = $user->contry;
            $model->surname = $user->surname;
            $model->name = $user->name;
            $model->region = $user->region;
            $model->city = $user->city;
            $model->house = $user->house;
            $model->postcode = $user->postcode;
            $model->phone = $user->phone;
        }

        if (Yii::$app->request->post("Address") && is_null($user)) {
            $model->attributes = Yii::$app->request->post("Address");
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->client = Yii::$app->user->getId();
                $model->save();
                $status["save"] = true;
            }
        }

        return $this->render('address', ["model" => $model, "status" => $status]);
    }
    public function actionAddTrackerClient()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect('signin');
        }

        $model = new AddTrackerClient();
        $model->name = Yii::$app->user->identity->username;

        $status = [];

        if (Yii::$app->request->post("AddTrackerClient")) {
            $model->attributes = Yii::$app->request->post("Address");
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $model->id_client = Yii::$app->user->getId();
                $model->date_time = time();
                $model->save();
                $status["save"] = true;
            }
        }

        return $this->render('add-tracker-client', ["model" => $model, "status" => $status]);
    }
    public function actionMyTracker()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect('signin');
        }

        $q = AddTrackerClient::find()->where(["id_client" => Yii::$app->user->getId()]);

        $dataProvider = new ActiveDataProvider([
            'query' => $q,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        $track = [];
        foreach ($q->all() as $key => $value) {
            $track['list'][] = $value->tracker;
        }

        $client = new Client(['baseUrl' => 'https://351cargo.com/api/v1/']);
        $newUserResponse = $client->post('tracker/get-tracker', $track)->send();

        $status = TrackerOtherSite::find()->where(['in', 'track', $track['list']])->all();
        return $this->render('my-tracker', [
            'dataProvider' => $dataProvider,
            'model' => $q->all(),
            'resultApi' => $status,
            'resultApiMao' => $newUserResponse->data
        ]);
    }

    public function actionDeleteTracker()
    {
        if (Yii::$app->user->getId() != 6) {
            return $this->redirect(['/']);
        }
        AddTrackerClient::find()->where(['id' => Yii::$app->request->get('id')])->one()->delete();
        $this->redirect(Yii::$app->request->referrer);
    }

    public function actionChangeAccount()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect('signin');
        }
        $model = new ChangeAccount();
        $user = User::find()->where(["id" => Yii::$app->user->getId()])->one();
        $model->username = $user->username;
        $model->email = $user->email;

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if ($model->change()) {
                Yii::$app->response->redirect('setting-account');
            }
        }

        return $this->render('setting-account', [
            'model' => $model
        ]);
    }
}
