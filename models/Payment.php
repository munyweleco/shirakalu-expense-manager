<?php

namespace app\models;

use \app\models\base\Payment as BasePayment;
use yii\web\ForbiddenHttpException;

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

    /**
     * Prevent deletion if the payment is finalized.
     * @throws ForbiddenHttpException
     */
    public function beforeDelete()
    {
        if ($this->is_finalized) {
            throw new ForbiddenHttpException('This payment has been finalized and cannot be deleted.');
        }
        return parent::beforeDelete();
    }


}
