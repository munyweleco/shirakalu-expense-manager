<?php

namespace app\models\base;

use Yii;
use app\common\models\BaseModel;

/**
* This is the base model class for table "{{%rates_history}}".
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
*/
class RatesHistory extends BaseModel
{

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%rates_history}}';
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

}
