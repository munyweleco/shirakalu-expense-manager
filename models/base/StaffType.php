<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%staff_type}}".
 *
 * @property int $id
 * @property string $staff_type
 * @property string $description
 * @property int $active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OperationRate[] $operationRates
 * @property RatesHistory[] $ratesHistories
 * @property Staff[] $staff
 */
class StaffType extends \app\common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%staff_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_type', 'description'], 'required'],
            [['description'], 'string'],
            [['active'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_type' => 'Staff Type',
            'description' => 'Description',
            'active' => 'Active',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[OperationRates]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperationRates()
    {
        return $this->hasMany(OperationRate::class, ['role_id' => 'id']);
    }

    /**
     * Gets query for [[RatesHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatesHistories()
    {
        return $this->hasMany(RatesHistory::class, ['role_id' => 'id']);
    }

    /**
     * Gets query for [[Staff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasMany(Staff::class, ['staff_role_id' => 'id']);
    }
}
