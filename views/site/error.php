<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card text-center">
            <div class="card-header bg-danger text-white">
                <h2><i class="fas fa-exclamation-triangle"></i> <?= Html::encode($name) ?></h2>
            </div>
            <div class="card-body">
                <h4><?= nl2br(Html::encode($message)) ?></h4>
                <p>
                    The above error occurred while the Web server was processing your request.
                    Please contact us if you think this is a server error. Thank you.
                </p>
            </div>
            <div class="card-footer text-muted">
                <?= Html::a('return to dashboard', Yii::$app->homeUrl, ['class' => 'btn btn-primary']); ?>
            </div>
        </div>
    </div>
</div>