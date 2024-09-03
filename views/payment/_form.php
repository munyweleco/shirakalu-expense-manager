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

<div class="payment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->errorSummary($model); ?>


    <?= $form->field($model, 'staff_id')->widget(Select2::class, [
        'data' => Staff::loadActiveStaff(),
        'options' => [
            'id' => 'staff-id',
            'disabled' => $disabled,
        ],
        'pluginOptions' => [
            'placeholder' => 'Choose Staff',
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'acres')->textInput(['maxlength' => true, 'placeholder' => 'Acres', 'readonly' => $disabled]) ?>


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
            'url' => yii\helpers\Url::to(['payment/get-operations'])
        ],
    ]); ?>

    <?= $form->field($model, 'use_custom_rate')->checkbox(['id' => 'use-custom-rate']) ?>

    <!-- This is the text field where the rate value will be populated -->
    <?= $form->field($model, 'rate')->textInput([
        'placeholder' => 'Payment rate',
        'readonly' => true,
    ]) ?>


    <?= $form->field($model, 'amount')->textInput(['readonly' => true, 'placeholder' => 'Amount']) ?>

    <?= $form->field($model, 'payment_date')->widget(\kartik\datecontrol\DateControl::class, [
        'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
        'saveFormat' => 'php:Y-m-d',
        'ajaxConversion' => true,
        'options' => [
            'pluginOptions' => [
                'placeholder' => 'Choose Payment Date',
                'autoclose' => true
            ]
        ],
    ]); ?>

    <?= $form->field($model, 'is_finalized')->checkbox([
        'label' => 'Finalize Payment (This will lock editing)',
        'disabled' => !$model->isNewRecord && $model->is_finalized,
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJsFile('@web/js/payment-form.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>
