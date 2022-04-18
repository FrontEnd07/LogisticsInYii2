<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;

/**
 * Tracker is the model behind the add tracker form.
 **/
class AddTrackerClient extends ActiveRecord
{

    public static function tableName()
    {
        return "add-tracker-client";
    }

    public function rules()
    {
        return [
            [["tracker", "name", "nameItem", "quantity"], 'required', 'message' => 'Заполните поле'],
            [["tracker", "name", "nameItem"], 'string'],
            [["tracker", "name", "nameItem", "quantity"], 'trim'],
            ['tracker', 'unique', 'targetClass' => AddTrackerClient::className(),  'message' => 'Этот трекер уже добавлен!'],
            [["quantity"], 'number', 'max' => 99999999999, 'message' => 'Только цифры'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tracker' => 'Трек-номер: (латинские буквы и цифры)',
            'name' => 'Имя',
            'nameItem' => 'Наименования товара',
            'quantity' => 'Количество',
        ];
    }
}
