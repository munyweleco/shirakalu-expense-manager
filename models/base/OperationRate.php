<?php

namespace app\models\base;

use Yii;
use app\common\models\BaseModel;

/**
* This is the base model class for table "{{%operation_rates}}".
*
* @property integer $id
* @property integer $operation_id
* @property integer $role_id
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
class OperationRate extends BaseModel
{

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%operation_rates}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['operation_id', 'role_id', 'rate', 'effective_date'], 'required'],
            [['operation_id', 'role_id'], 'integer'],
            [['rate'], 'number'],
            [['effective_date', 'created_at', 'updated_at'], 'safe'],
            [['unit'], 'string', 'max' => 10],
            [['description'], 'string', 'max' => 100]
        ];
    }

    /**
    * @inheritdoc
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
    public function getRole()
    {
        return $this->hasOne(\app\models\base\StaffType::className(), ['id' => 'role_id']);
    }

}
