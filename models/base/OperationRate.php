<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%operation_rates}}".
 *
 * @property int $id
 * @property int $operation_id
 * @property int $role_id
 * @property float $rate
 * @property string $effective_date
 * @property string $unit
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Operation $operation
 * @property StaffType $role
 */
class OperationRate extends \app\common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%operation_rates}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operation_id', 'role_id', 'rate', 'effective_date'], 'required'],
            [['operation_id', 'role_id'], 'integer'],
            [['rate'], 'number'],
            [['effective_date', 'created_at', 'updated_at'], 'safe'],
            [['unit'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 100],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::class, 'targetAttribute' => ['operation_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffType::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operation_id' => 'Operation ID',
            'role_id' => 'Role ID',
            'rate' => 'Rate',
            'effective_date' => 'Effective Date',
            'unit' => 'Unit',
            'description' => 'Description',
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
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(StaffType::class, ['id' => 'role_id']);
    }
}
