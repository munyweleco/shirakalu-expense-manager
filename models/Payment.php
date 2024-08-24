<?php

namespace app\models;

use \app\models\base\Payment as BasePayment;

/**
 * This is the model class for table "payments".
 * @property float $rate_value
 */
class Payment extends BasePayment
{
    public float $rate_value = 0.0;
    public bool $use_custom_rate = false;

    public function attributeLabels(): array
    {
        $labels = parent::attributeLabels();
        $labels['staff_id'] = 'Staff name';
        $labels['rate_value'] = 'Current payment rate';
        $labels['operation_id'] = 'Farm operation';
        return $labels;
    }
}
