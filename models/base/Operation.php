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

}
