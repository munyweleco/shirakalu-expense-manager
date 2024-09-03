<?php /** @noinspection ALL */

namespace app\controllers;

use app\common\controllers\BaseWebController;
use app\models\ChangePasswordForm;
use app\models\Operation;
use app\models\Payment;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends BaseWebController
{

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $startDate = date('Y-m-01');
        $endDate = date('Y-m-t');

        // Count of finalized and unfinalized payments
        $finalizedPaymentsCount = Payment::find()->where(['is_finalized' => 1])->count();
        $unfinalizedPaymentsCount = Payment::find()->where(['is_finalized' => 0])->count();

        // Total number of payments
        $totalPaymentsCount = $finalizedPaymentsCount + $unfinalizedPaymentsCount;

        // Calculate percentages
        $finalizedPaymentsPercentage = $totalPaymentsCount > 0 ? round(($finalizedPaymentsCount / $totalPaymentsCount) * 100) : 0;
        $unfinalizedPaymentsPercentage = $totalPaymentsCount > 0 ? round(($unfinalizedPaymentsCount / $totalPaymentsCount) * 100) : 0;

        // Other metrics
        $paymentsThisMonthCount = Payment::find()->where(['between', 'payment_date', $startDate, $endDate])->count();

        $minPaymentAmount = Payment::find()->where(['between', 'payment_date', $startDate, $endDate])->min('amount');
        $maxPaymentAmount = Payment::find()->where(['between', 'payment_date', $startDate, $endDate])->max('amount');

        $totalOperationsConducted = Operation::find()->count();
        $topOperationsByProfit = [];

        return $this->render('index', [
            'finalizedPaymentsCount' => $finalizedPaymentsCount,
            'unfinalizedPaymentsCount' => $unfinalizedPaymentsCount,
            'finalizedPaymentsPercentage' => $finalizedPaymentsPercentage,
            'unfinalizedPaymentsPercentage' => $unfinalizedPaymentsPercentage,
            'paymentsThisMonthCount' => $paymentsThisMonthCount,
            'maxPaymentAmount' => $maxPaymentAmount,
            'minPaymentAmount' => $minPaymentAmount,
            'topOperationsByProfit' => $topOperationsByProfit,
            'totalOperationsConducted' => $totalOperationsConducted,
        ]);
    }

    public function actionIndexOld()
    {
        $this->view->title = "Shirakalu resort manager";
        return $this->render('index-old');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        $this->layout = 'main-login';
        $this->view->title = "Login";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionChangePassword(): Response|string
    {
        $this->view->title = "Change Password";
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                Yii::$app->session->setFlash('success', 'Password changed successfully.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Failed to change password.');
        }

        $model->currentPassword = '';
        $model->newPassword = '';
        $model->confirmPassword = '';
        return $this->render('change-password', ['model' => $model]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
