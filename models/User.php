<?php

namespace app\models;

use \app\models\base\User as BaseUser;

/**
 * This is the model class for table "users".
 */
class User extends BaseUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return parent::rules(); // TODO: Change the autogenerated stub
    }

}
