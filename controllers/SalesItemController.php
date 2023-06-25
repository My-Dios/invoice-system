<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\TrSalesItem;
use app\components\ResponsesHelper;

class SalesItemController extends Controller
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
        $model = TrSalesItem::find()->all();
        $response = ResponsesHelper::getResponseIndex($model);
        return $response;
    }

    public function actionView($salesNum)
    {
        $model = TrSalesItem::findOne(['salesNum' => $salesNum]);
        $response = ResponsesHelper::getResponseView($model, 'Invoice');
        return $response;
    }
}
