<?php

namespace app\models;

use \app\models\base\OperationRate as BaseOperationRate;
use yii\db\Exception;

/**
 * This is the model class for table "operation_rates".
 */
class OperationRate extends BaseOperationRate
{

    /**
     * @throws Exception
     */
    public static function loadRates(mixed $operation_id, mixed $staff_id)
    {
        $sql = <<<SQL
    SELECT
        staff.staff_name,
        staff_type.staff_type,
        operations.name,
        operation_rates.rate,
        operation_rates.operation_id,
        staff.id AS staff_id,
        staff.staff_role_id 
    FROM
        operations
    INNER JOIN operation_rates ON operations.id = operation_rates.operation_id
    INNER JOIN staff_type ON operation_rates.role_id = staff_type.id
    INNER JOIN staff ON staff.staff_role_id = staff_type.id
    WHERE
        staff.id = :staff_id AND
        operation_rates.operation_id = :operation_id
SQL;

        return \Yii::$app->db->createCommand($sql)
            ->bindValue(':staff_id', $staff_id)
            ->bindValue(':operation_id', $operation_id)
            ->queryOne();

    }
}
