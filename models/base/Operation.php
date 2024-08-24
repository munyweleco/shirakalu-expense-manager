<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "{{%operations}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OperationRate[] $operationRates
 * @property Payment[] $payments
 * @property RatesHistory[] $ratesHistories
 */
class Operation extends \app\common\models\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%operations}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
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
        return $this->hasMany(OperationRate::class, ['operation_id' => 'id']);
    }

    /**
     * Gets query for [[Payments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::class, ['operation_id' => 'id']);
    }

    /**
     * Gets query for [[RatesHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRatesHistories()
    {
        return $this->hasMany(RatesHistory::class, ['operation_id' => 'id']);
    }
}
