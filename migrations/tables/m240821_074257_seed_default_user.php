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
        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@admin.com';
        $user->setPassword('admin');
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
