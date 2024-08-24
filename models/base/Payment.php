<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%payments}}".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $operation_id
 * @property float $rate
 * @property float $acres
 * @property float $amount
 * @property string $payment_date
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Operation $operation
 * @property Staff $staff
 */
class Payment extends \app\common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%payments}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'operation_id', 'rate', 'acres', 'amount', 'payment_date'], 'required'],
            [['staff_id', 'operation_id'], 'integer'],
            [['rate', 'acres', 'amount'], 'number'],
            [['payment_date', 'created_at', 'updated_at'], 'safe'],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::class, 'targetAttribute' => ['operation_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::class, 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Operation]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::class, ['id' => 'operation_id']);
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Staff::class, ['id' => 'staff_id']);
    }
}
