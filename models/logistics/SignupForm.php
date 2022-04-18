<?php

namespace app\models\logistics;

use yii\db\ActiveRecord;
use app\models\User;

class SignupForm extends ActiveRecord
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
            [['username'], 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
            [["email"], 'unique', 'targetClass' => User::className(),  'message' => 'Этот email уже занят'],
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

    public function signUp()
    {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);

        return $user->save();
    }
}
