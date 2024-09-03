<?php


namespace app\common\controllers;


use app\components\PasswordChangeBehavior;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 *
 * @property-read mixed $cacheShop
 */
class BaseWebController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'except' => ['login', 'error', 'captcha'], // Actions accessible without login
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'], // Allow authenticated users
                ],
            ],
        ];

        $behaviors['passwordChange'] = [
            'class' => PasswordChangeBehavior::class,
            'except' => ['login', 'change-password','error'], //Actions accessible
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'logout' => ['post'],
            ],
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => '@app/views/layouts/error',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

}
