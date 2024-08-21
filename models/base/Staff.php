<?php

namespace app\models\base;

use Yii;
use app\common\models\BaseModel;

/**
* This is the base model class for table "{{%staff}}".
*
* @property integer $id
* @property string $staff_name
* @property integer $staff_role_id
* @property string $created_at
* @property string $updated_at
*/
class Staff extends BaseModel
{

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return '{{%staff}}';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['staff_name', 'staff_role_id'], 'required'],
            [['staff_role_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_name'], 'string', 'max' => 100]
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_name' => 'Staff Name',
            'staff_role_id' => 'Staff Role ID',
        ];
    }

}
