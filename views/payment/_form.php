<?php /** @noinspection PhpUnhandledExceptionInspection */

use app\models\Operation;
use app\models\Staff;
use kartik\depdrop\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Payment */
/* @var $form kartik\widgets\ActiveForm */

$disabled = !$model->isNewRecord && $model->is_finalized;
?>

<div class="row mt-5">
    <div class="payment-form">
        <div class="card">

            <div class="card-header">
                <h5>Payment Details</h5>
            </div>

            <div class="card-body">
                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'row g-3'],
                ]); ?>

                <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

                <div class="col-md-6">
                    <?= $form->field($model, 'staff_id')->widget(Select2::class, [
                        'data' => Staff::loadActiveStaff(),
                        'options' => [
                            'id' => 'staff-id',
                            'disabled' => $disabled,
                        ],
                        'pluginOptions' => [
                            'placeholder' => 'Choose Staff',
                            'allowClear' => true,
                        ],
                    ]); ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'acres')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Acres',
                        'readonly' => $disabled,
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'operation_id')->widget(DepDrop::class, [
                        'type' => DepDrop::TYPE_SELECT2,
                        'options' => [
                            'id' => 'operation-id',
                        ],
                        'data' => $model->isNewRecord ? [] : [$model->operation_id => $model->operation->name],
                        'pluginOptions' => [
                            'initialize' => !$model->isNewRecord,
                            'depends' => ['staff-id'],
                            'placeholder' => 'Choose operations',
                            'url' => yii\helpers\Url::to(['payment/get-operations']),
                        ],
                    ]); ?>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <?= $form->field($model, 'use_custom_rate', [
                        'options' => ['class' => 'form-check'],
                    ])->checkbox(['id' => 'use-custom-rate']) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'rate')->textInput([
                        'placeholder' => 'Payment rate',
                        'readonly' => true,
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'amount')->textInput([
                        'readonly' => true,
                        'placeholder' => 'Amount',
                    ]) ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'payment_date')->widget(\kartik\datecontrol\DateControl::class, [
                        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                        'saveFormat' => 'php:Y-m-d',
                        'ajaxConversion' => true,
                        'options' => [
                            'pluginOptions' => [
                                'placeholder' => 'Choose Payment Date',
                                'autoclose' => true,
                            ],
                        ],
                    ]); ?>
                </div>

                <div class="col-md-6 d-flex align-items-center">
                    <?= $form->field($model, 'is_finalized', [
                        'options' => ['class' => 'form-check'],
                    ])->checkbox([
                        'label' => 'Finalize Payment (This will lock editing)',
                        'disabled' => !$model->isNewRecord && $model->is_finalized,
                    ]) ?>
                </div>

                <div class="col-12 text-center mt-4">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [
                        'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    ]) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>

        </div>
    </div>
</div>

<?php
$this->registerJsFile('@web/js/payment-form.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
