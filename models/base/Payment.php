<?php

namespace app\models\base;

use Yii;
use app\common\models\BaseModel;

/**
* This is the base model class for table "{{%payments}}".
*
* @property integer $id
* @property integer $staff_id
* @property integer $operation_id
* @property float $rate
* @property float $acres
* @property float $amount
* @property string $payment_date
* @property string $created_at
* @property string $updated_at
*/
class Payment extends BaseModel
{

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%payments}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['staff_id', 'operation_id', 'rate', 'acres', 'amount', 'payment_date'], 'required'],
            [['staff_id', 'operation_id'], 'integer'],
            [['rate', 'acres', 'amount'], 'number'],
            [['payment_date', 'created_at', 'updated_at'], 'safe']
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'operation_id' => 'Operation ID',
            'rate' => 'Rate',
            'acres' => 'Acres',
            'amount' => 'Amount',
            'payment_date' => 'Payment Date',
        ];
    }

}
