<?php

namespace app\models\base;

use Yii;
use app\common\models\BaseModel;

/**
* This is the base model class for table "{{%staff_type}}".
*
* @property integer $id
* @property string $staff_type
* @property string $description
* @property boolean $active
* @property string $created_at
* @property string $updated_at
*
* @property OperationRate[] $operationRates
* @property RatesHistory[] $ratesHistories
* @property Staff[] $staff
*/
class StaffType extends BaseModel
{

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%staff_type}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['staff_type', 'description'], 'required'],
            [['description'], 'string'],
            [['active'], 'boolean'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_type'], 'string', 'max' => 20]
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_type' => 'Staff Type',
            'description' => 'Description',
            'active' => 'Active',
        ];
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getOperationRates()
    {
        return $this->hasMany(\app\models\base\OperationRate::className(), ['role_id' => 'id']);
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getRatesHistories()
    {
        return $this->hasMany(\app\models\base\RatesHistory::className(), ['role_id' => 'id']);
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getStaff()
    {
        return $this->hasMany(\app\models\base\Staff::className(), ['staff_role_id' => 'id']);
    }

}
