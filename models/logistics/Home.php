<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;

/**
 * Tracker is the model behind the add tracker form.
 **/
class Home extends ActiveRecord
{
    public $tracker;

    public static function tableName()
    {
        return "home";
    }
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['tracker'], 'required', 'message' => "Пожалуйста, введите трекер!"],
        ];
    }
}
