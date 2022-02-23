<?php

namespace app\models\logistics;

use Yii;
use yii\db\ActiveRecord;

/**
 * Tracker is the model behind the add tracker form.
 **/
class AddProgress extends ActiveRecord
{

    public static function tableName()
    {
        return "add-progress";
    }
}
