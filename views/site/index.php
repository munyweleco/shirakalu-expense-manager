<?php
/** @var yii\web\View $this */
/** @var int $unfinalizedPaymentsCount Count of unfinalized payments */
/** @var int $finalizedPaymentsCount Count of finalized payments */
/** @var float $finalizedPaymentsPercentage Percentage of finalized payments */
/** @var float $unfinalizedPaymentsPercentage Percentage of unfinalized payments */
/** @var int $paymentsThisMonthCount Count of payments made in the current month */
/** @var float $minPaymentAmount The lowest payment amount across all operations */
/** @var float $maxPaymentAmount The highest payment amount across all operations */
/** @var app\models\Operation[] $topOperationsByProfit Top 5 operations by profit */

/** @var int $totalOperationsConducted The total number of operations conducted */

use hail812\adminlte\widgets\InfoBox;
use yii\helpers\Html;

$this->params['breadcrumbs'] = [['label' => $this->title]];

?>

<div class="container-fluid mt-5">
    <div class="row">
        <!-- Unfinalized Payments -->
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'id' => 'bookmark-info-box',
                'text' => 'Unfinalized Payments',
                'number' => $unfinalizedPaymentsCount,
                'theme' => 'info',
                'icon' => 'fa fa-hourglass-start',
                'progress' => [
                    'width' => "$unfinalizedPaymentsPercentage%",
                    'description' => "$unfinalizedPaymentsPercentage% Increase in 30 Days"
                ],
                'loadingStyle' => false
            ])
            ?>
        </div>

        <!-- Finalized Payments -->
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Finalized Payments',
                'number' => $finalizedPaymentsCount,
                'theme' => 'success',
                'icon' => 'fa fa-hourglass-end',
                'progress' => [
                    'width' => "$finalizedPaymentsPercentage%",
                    'description' => "$finalizedPaymentsPercentage% Increase in 30 Days"
                ],
            ]) ?>
        </div>

        <!-- Payments This Month -->
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Payments This Month',
                'number' => $paymentsThisMonthCount,
                'theme' => 'info',
                'icon' => 'far fa-calendar-alt',
                'icon' => 'fa fa-hourglass-end',
                'progress' => [
                    'width' => "0%",
                    'description' => "$paymentsThisMonthCount Payments"
                ],
            ]) ?>
        </div>
    </div>

    <div class="row mt-4">

        <!-- Lowest Payment by Operation -->
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Lowest Payment by Operation',
                'number' => Yii::$app->formatter->asCurrency($minPaymentAmount),
                'theme' => 'danger',
                'icon' => 'fa fa-money-check',
            ]) ?>
        </div>

        <!-- Highest Payment by Operation -->
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Highest Payment by Operation',
                'number' => Yii::$app->formatter->asCurrency($maxPaymentAmount),
                'theme' => 'primary',
                'icon' => 'fa fa-money-bill',
            ]) ?>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Total Operations Conducted -->
        <div class="col-md-4 col-sm-6 col-12">
            <?= InfoBox::widget([
                'text' => 'Total Operations Conducted',
                'number' => $totalOperationsConducted,
                'theme' => 'info',
                'icon' => 'fas fa-seedling',
            ]) ?>
        </div>

        <!-- Top Operations by Profit -->
        <?php foreach ($topOperationsByProfit as $operation): ?>
            <div class="col-md-4 col-sm-6 col-12">
                <?= InfoBox::widget([
                    'text' => 'Operation: ' . Html::encode($operation->operation_id),
                    'number' => Yii::$app->formatter->asCurrency($operation->total_profit),
                    'theme' => 'secondary',
                    'icon' => 'fas fa-chart-line',
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

