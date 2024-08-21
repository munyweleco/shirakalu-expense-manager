<?php

use app\common\models\User;
use yii\db\Migration;

/**
 * Class m240821_074257_seed_default_user
 */
class m240821_074257_seed_default_user extends Migration
{
    /**
     * {@inheritdoc}
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function safeUp(): void
    {
        $adminUser = \yii\helpers\ArrayHelper::getValue($_ENV, 'ADMIN_USER', 'admin');
        $adminPass = \yii\helpers\ArrayHelper::getValue($_ENV, 'ADMIN_PASS', 'admin');

        $user = new User();
        $user->id = 1;
        $user->username = $adminUser;
        $user->email = 'admin@shirakalu.co.ke';
        $user->setPassword(password: $adminPass);
        $user->generateAuthKey();
        $user->change_password = 1;

        if (!$user->validate()) {
            // If validation fails, throw an exception with error details
            $errors = $user->getErrors();
            $errorMessage = 'Validation failed: ' . json_encode($errors);
            throw new \yii\db\Exception($errorMessage);
        }

        // Save the user if validation is successful
        if (!$user->save(false)) {
            throw new \yii\db\Exception('Failed to save the user.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $user = User::findByUsername('admin');
        $user?->delete();
    }

}
