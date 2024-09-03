<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PaymentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payment-index">

    <p>
        <?= Html::a('Add Payment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $gridColumn = [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'attribute' => 'staff_id',
            'value' => function ($model) {
                /* @var $model \app\models\Payment */
                return $model->staff->staff_name;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \app\models\Staff::loadActiveStaff(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Staff', 'id' => 'grid-staff_id']
        ],
        [
            'attribute' => 'operation_id',
            'label' => 'Operation',
            'value' => function ($model) {
                return $model->operation->name;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \app\models\Operation::loadOperations(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Operations', 'id' => 'grid-operation_id']
        ],
        'rate:currency',
        'acres:decimal',
        'amount:currency',
        'payment_date:date',
        [
            'class' => 'kartik\grid\ActionColumn',
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-payment']],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<span class="glyphicon glyphicon-book"></span>  ' . Html::encode($this->title),
        ],
        'export' => false,
    ]); ?>

</div>
