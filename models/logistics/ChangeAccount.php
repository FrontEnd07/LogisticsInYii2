<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;
use app\models\User;

class ChangeAccount extends ActiveRecord
{

    public $username;
    public $password;
    public $email;

    public static function tableName()
    {
        return "user";
    }


    public function rules()
    {
        return [
            [['username', 'password', 'email'], 'required', 'message' => 'Заполните поле'],
            [['username', 'password', 'email'], 'trim'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Email'
        ];
    }

    public function change()
    {
        $user = User::find()->where(['id' => Yii::$app->user->getId()])->one();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);

        return $user->save();
    }
}
