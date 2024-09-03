<?php
/** @noinspection PhpUnhandledExceptionInspection */
/* @var $this yii\web\View */

/* @var $model app\models\ChangePasswordForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;


$this->registerJsFile('@web/js/password-toggle.js', ['depends' => [\yii\web\JqueryAsset::class]]);

?>


<div class="row justify-content-center mt-5">
    <div class="col-lg-6 col-md-8 col-sm-10">
        <div class="card">
            <div class="card-header">
                <h4><?= Html::encode($this->title) ?></h4>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="card-body">

                <?= $form->field($model, 'currentPassword', [
                    'addon' => [
                        'append' => [
                            'content' => '<button type="button" class="btn btn-outline-secondary"><i class="fa fa-eye"></i></button>',
                            'asButton' => true,
                        ],
                    ],
                    'inputOptions' => [
                        'id' => 'currentPassword',
                        'class' => 'form-control',
                        'placeholder' => 'Current Password'
                    ]
                ])->passwordInput() ?>


                <?= $form->field($model, 'newPassword', [
                    'addon' => [
                        'append' => [
                            'content' => '<button type="button" class="btn btn-outline-primary" id="toggleNewPassword"><i class="fa fa-eye"></i></button>',
                            'asButton' => true,
                        ],
                    ],
                    'inputOptions' => [
                        'id' => 'newPassword',
                        'class' => 'form-control',
                        'placeholder' => 'New Password'
                    ]
                ])->passwordInput() ?>

                <?= $form->field($model, 'confirmPassword', [
                    'addon' => [
                        'append' => [
                            'content' => '<button type="button" class="btn btn-outline-primary" id="toggleConfirmPassword"><i class="fa fa-eye"></i></button>',
                            'asButton' => true,
                        ],
                    ],
                    'inputOptions' => [
                        'id' => 'confirmPassword',
                        'class' => 'form-control',
                        'placeholder' => 'Confirm Password'
                    ]
                ])->passwordInput() ?>

            </div>
            <div class="card-footer">
                <div class="form-group">
                    <?= Html::submitButton('Change Password', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
