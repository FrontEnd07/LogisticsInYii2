<?php

namespace app\models\logistics;

use Yii;
use yii\base\Model;

/**
 * AddTracker is the model behind the add tracker form.
 **/
class AddTracker extends Model
{
    public $username;
    public $tracker;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and tracker are both required
            [['username'], 'required', 'message' => "Пожалуйста, введите имя!"],
            [['tracker'], 'required', 'message' => "Пожалуйста, укажите трекеры"],
        ];
    }
}
