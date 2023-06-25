<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\TrInvoice;
use app\components\ResponsesHelper;

class InvoiceController extends Controller
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
            ],
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        $model = TrInvoice::find()->all();
        $response = ResponsesHelper::getResponseIndex($model);
        return $response;
    }

    public function actionView($salesNum)
    {
        $model = TrInvoice::findOne(['salesNum' => $salesNum]);
        $response = ResponsesHelper::getResponseView($model, 'Invoice');
        return $response;
    }
}
