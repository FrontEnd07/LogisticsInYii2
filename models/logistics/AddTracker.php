<?php

namespace app\models\logistics;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

/**
 * AddTracker is the model behind the add tracker form.
 **/
class AddTracker extends ActiveRecord
{
    public $username;
    public $location;
    public $tracker;

    public static function tableName()
    {
        return "tracker";
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and tracker are both required
            [['username'], 'required', 'message' => "Пожалуйста, введите имя!"],
            [['location'], 'required', 'message' => "Пожалуйста, укажите город!"],
            [['tracker'], 'required', 'message' => "Пожалуйста, укажите трекеры"],
        ];
    }
}
