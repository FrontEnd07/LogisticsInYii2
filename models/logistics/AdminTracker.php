<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;

/**
 * Tracker is the model behind the add tracker form.
 **/
class AdminTracker extends ActiveRecord
{
    public $username;
    public $selection;


    public function rules()
    {
        return [
            [["username", 'selection'], 'required', 'message' => 'Заполните поле'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя клиента',
        ];
    }
}
