<?php

namespace app\models;

use \app\models\base\Operation as BaseOperation;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "operations".
 */
class Operation extends BaseOperation
{

    /**
     * @return array
     */
    public static function loadOperations(): array
    {
        $operations = Operation::find()->all();
        return ArrayHelper::map($operations, 'id', 'name');
    }
}
