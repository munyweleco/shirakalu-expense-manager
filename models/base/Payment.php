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
* @property boolean $is_finalized
* @property string $created_at
* @property string $updated_at
*
* @property Operation $operation
* @property Staff $staff
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
            [['payment_date', 'created_at', 'updated_at'], 'safe'],
            [['is_finalized'], 'boolean']
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
            'is_finalized' => 'Finalize payment',
        ];
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getOperation()
    {
        return $this->hasOne(\app\models\base\Operation::className(), ['id' => 'operation_id']);
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getStaff()
    {
        return $this->hasOne(\app\models\base\Staff::className(), ['id' => 'staff_id']);
    }

}
