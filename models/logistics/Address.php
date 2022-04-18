<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;

/**
 * Tracker is the model behind the add tracker form.
 **/
class Address extends ActiveRecord
{

    public static function tableName()
    {
        return "address";
    }

    public function rules()
    {
        return [
            [["contry", "surname", "name", "region", "city", "house", "postcode", "phone"], 'required', 'message' => 'Заполните поле'],
            [["contry", "surname", "name", "region", "city", "house", "postcode", "phone"], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'contry' => 'Страна (выбирайте свою страну без ошибок!)',
            'surname' => 'Фамилия',
            'name' => 'Имя (Имя + Отчество для жителей России)',
            'region' => 'Край/Область/Регион',
            'city' => 'Город',
            'house' => 'Улица, дом, квартира',
            'postcode' => 'Почтовый индекс (необязательное поле, нужно для доставки Почтой)',
            'phone' => 'Номер телефона',
        ];
    }
}
