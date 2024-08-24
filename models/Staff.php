<?php

namespace app\models;

use \app\models\base\Staff as BaseStaff;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "staff".
 */
class Staff extends BaseStaff
{

    public static function loadActiveStaff(): array
    {
        $staff = self::find()->orderBy('id')->asArray()->all();
        return ArrayHelper::map($staff, 'id', 'staff_name');
    }

}
