<?php

namespace app\models\logistics;

use yii\db\ActiveRecord;
use app\models\User;

class SignIn extends ActiveRecord
{

    public $password;
    public $email;
    public $rememberMe = true;

    public static function tableName()
    {
        return "user";
    }


    public function rules()
    {
        return [
            [['password', 'email'], 'required', 'message' => 'Заполните поле'],
            ["password", "validatePassword"],
            [['password', 'email'], 'trim'],
            ['email', 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'email' => 'Email',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, "Пароль или Email введены неверно!");
            }
        }
    }
    public function getUser()
    {
        return User::findOne(["email" => $this->email]);
    }
}
