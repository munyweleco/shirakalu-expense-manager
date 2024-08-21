<?php

namespace app\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;

/**
 * @property string $currentPassword
 * @property string $newPassword
 * @property string $confirmPassword
 */
class ChangePasswordForm extends Model
{
    public ?string $currentPassword = null;
    public ?string $newPassword = null;
    public ?string $confirmPassword = null;

    /**
     * @return array the validation rules.
     */
    public function rules(): array
    {
        return [
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required'],
            [['newPassword', 'confirmPassword'], 'string', 'min' => 6],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword'],
            ['currentPassword', 'validateCurrentPassword'],
        ];
    }

    /**
     * Validates the current password.
     * This method serves as the inline validation for currentPassword.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateCurrentPassword(string $attribute): void
    {
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->currentPassword)) {
            $this->addError($attribute, 'Incorrect current password.');
        }
    }

    /**
     * Changes the user's password.
     * @return bool whether the password was changed successfully
     * @throws Exception
     */
    public function changePassword(): bool
    {
        $user = Yii::$app->user->identity;
        if ($user) {
            $user->setPassword($this->newPassword);
            $user->change_password = 0;
            $user->generateAuthKey(); // Optional, depending on your authentication strategy
            return $user->save();
        }
        return false;
    }
}