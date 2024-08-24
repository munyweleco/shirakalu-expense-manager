<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%staff}}".
 *
 * @property int $id
 * @property string $staff_name
 * @property int $staff_role_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Payment[] $payments
 * @property StaffType $staffRole
 */
class Staff extends \app\common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%staff}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_name', 'staff_role_id'], 'required'],
            [['staff_role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_name'], 'string', 'max' => 100],
            [['staff_role_id'], 'exist', 'skipOnError' => true, 'targetClass' => StaffType::class, 'targetAttribute' => ['staff_role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_name' => 'Staff Name',
            'staff_role_id' => 'Staff Role ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['staff_id' => 'id']);
    }

    /**
     * Gets query for [[StaffRole]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStaffRole()
    {
        return $this->hasOne(StaffType::class, ['id' => 'staff_role_id']);
    }
}
