<?php

namespace app\models\base;

use Yii;
use app\common\models\BaseModel;

/**
* This is the base model class for table "{{%operations}}".
*
* @property integer $id
* @property string $name
* @property string|null $description
* @property string $created_at
* @property string $updated_at
*
* @property OperationRate[] $operationRates
* @property Payment[] $payments
* @property RatesHistory[] $ratesHistories
*/
class Operation extends BaseModel
{

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%operations}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getOperationRates()
    {
        return $this->hasMany(\app\models\base\OperationRate::className(), ['operation_id' => 'id']);
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getPayments()
    {
        return $this->hasMany(\app\models\base\Payment::className(), ['operation_id' => 'id']);
    }
    /**
    * Record relations here
    * @return yii\db\ActiveQuery
    */
    public function getRatesHistories()
    {
        return $this->hasMany(\app\models\base\RatesHistory::className(), ['operation_id' => 'id']);
    }

}
