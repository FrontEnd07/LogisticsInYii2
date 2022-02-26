<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;
use app\models\logistics\AddProgress;

/**
 * Tracker is the model behind the add tracker form.
 **/
class Tracker extends ActiveRecord
{
    public $username;
    public $location;
    public $tracker;
    public $position;

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
            [['username', 'position', 'location', 'tracker'], 'required', 'message' => "Поля не должно быть пустым!"],
        ];
    }
    public function getProgress()
    {
        return $this->hasMany(AddProgress::class, ['id' => 'customer_id']);
    }
}
