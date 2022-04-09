<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{
    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
}
