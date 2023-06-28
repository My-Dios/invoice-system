<?php

namespace app\controllers;

use Yii;
use app\models\TrSalesHead;
use app\models\MsCustomer;
use app\models\MsItem;
use app\models\TrInvoice;
use app\models\TrTransaction;
use app\models\TrSalesItem;
use Exception;
use app\components\ResponsesHelper;
use yii\web\BadRequestHttpException;

class TransactionController extends \yii\rest\Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::class,
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];
        $behaviors['verbFilter'] = [
            'class' => \yii\filters\VerbFilter::class,
            'actions' => [
                'index' => ['GET'],
                'view' => ['GET'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];
        return $behaviors;
    }
    

    public function actionIndex()
    {
        $transactionModel = new TrTransaction();
        $response = $transactionModel->getIndexData();
        return $response;
    }

    public function actionView($salesNum)
    {
        $model = new TrTransaction();
        $response = $model->getViewData($salesNum);
        return $response;
    }

    public function actionDelete($salesNum)
    {
        $model = new TrTransaction();
        $response = $model->deleteTransaction($salesNum);
        return $response;
    }

    public function actionUpdateTransaction($salesNum)
    {
        $request = Yii::$app->request->post();
        $model = new TrTransaction();
        $response = $model->updateTransaction($salesNum, $request);
        return $response;
    }


    public function actionCreateTransaction()
    {
        $request = Yii::$app->request->post();
        $transactionModel = new TrTransaction();
        return $transactionModel->createTransaction($request);
    }
}

