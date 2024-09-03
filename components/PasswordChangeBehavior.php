<?php

namespace app\components;

use Yii;
use yii\base\Behavior;
use yii\base\Controller as ControllerAlias;
use yii\base\ExitException;

class PasswordChangeBehavior extends Behavior
{
    public array $except = [];
    public array $only = [];

    /**
     * @inheritdoc
     */
    public function events(): array
    {
        return [
            ControllerAlias::EVENT_BEFORE_ACTION => 'checkPasswordChange',
        ];
    }

    /**
     * Redirects to the password change page if the user needs to change their password.
     * @param yii\base\ActionEvent $event
     * @throws ExitException|yii\base\InvalidRouteException
     * @noinspection PhpUnused
     */
    public function checkPasswordChange(yii\base\ActionEvent $event): void
    {
        $actionId = $event->action->id;

        if (!in_array($actionId, $this->except)) {
            $user = Yii::$app->user->identity;
            if ($user instanceof \app\common\models\User && $user->needsPasswordChange()) {
                // Redirect to password change page
                Yii::$app->response->redirect(['site/change-password']);
                Yii::$app->end();
            }
        }
    }
}