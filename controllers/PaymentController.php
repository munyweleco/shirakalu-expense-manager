<?php

namespace app\controllers;

use app\models\Operation;
use app\models\OperationRate;
use app\models\search\PaymentSearch;
use app\models\Staff;
use Yii;
use app\models\Payment;
use yii\data\ActiveDataProvider;
use app\common\controllers\BaseWebController;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * PaymentController implements the CRUD actions for Payment model.
 */
class PaymentController extends BaseWebController
{

    /**
     * Lists all Payment models.
     * @return string
     */
    public function actionIndex(): string
    {
        $this->view->title = 'Payment';
        $searchModel = new PaymentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payment model.
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id): string
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Payment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(): mixed
    {
        $model = new Payment();

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->acres = 2;
        $model->payment_date = date('Y-m-d'); //use current date as default
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Payment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws Exception
     */
    public function actionUpdate($id): string|Response
    {
        $model = $this->findModel($id);

        if ($model->is_finalized) {
            Yii::$app->session->setFlash('error', 'This payment has been finalized and cannot be edited.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->loadAll(Yii::$app->request->post()) && $model->saveAll()) {
            Yii::$app->session->setFlash('success', 'Payment updated successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Payment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->is_finalized) {
            Yii::$app->session->setFlash('error', 'This payment has been finalized and cannot be deleted.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->deleteWithRelated();
        return $this->redirect(['index']);
    }


    /**
     * Finds the Payment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payment::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * @return Response
     */
    public function actionGetOperations(): Response
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = Yii::$app->request->post('depdrop_all_params');
            $staff_id = ArrayHelper::getValue($ids, 'staff-id');
            if ($staff_id !== null) {
                $operations = Operation::find()
                    ->orderBy('name')
                    ->asArray()
                    ->all();
                foreach ($operations as $operation) {
                    $out[] = ['id' => $operation['id'], 'name' => $operation['name']];
                }
                return $this->asJson(['output' => $out, 'selected' => '']);
            }
        }

        return $this->asJson(['output' => '', 'selected' => '']);
    }

    /**
     * @return Response
     * @throws BadRequestHttpException
     */
    public function actionGetRate(): Response
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException('This action can only be accessed via AJAX.');
        }

        $operationId = Yii::$app->request->post('operation_id', 0);
        $staffId = Yii::$app->request->post('staff_id', 0);

        $staffRoles = Staff::find()->select('staff_role_id')->where(['id' => $staffId])->asArray();
        /* @var $operationRate OperationRate */
        $operationRate = OperationRate::find()
            ->where(['operation_id' => $operationId, 'role_id' => $staffRoles])
            ->orderBy(['effective_date' => SORT_DESC])
            ->one();
        if ($operationRate !== null) {
            return $this->asJson(['rate' => $operationRate->rate]);
        }


        return $this->asJson(['rate' => 0]);
    }
}
