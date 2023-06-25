<?php

namespace app\controllers;

use Yii;
use app\models\MsCustomer;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\components\ResponsesHelper;

class CustomerController extends Controller
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
        $model = MsCustomer::find()->all();
        $response = ResponsesHelper::getResponseIndex($model);
        return $response;
    }

    public function actionView($id)
    {
        $model = MsCustomer::findOne(['customerID' => $id]);
        $response = ResponsesHelper::getResponseView($model, 'Customer');
        return $response;
    }

    public function actionCreate()
    {
        $model = new MsCustomer();
        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->save()) {            
            return ['status' => 'success', 'message' => 'Customer created successfully', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to create customer', 'errors' => $model->errors];
        }
    }

    public function actionUpdate($id)
    {
        $model = MsCustomer::findOne(['customerID' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException("Customer not found.");
        }
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return ['status' => 'success', 'message' => 'Customer updated successfully', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to update customer', 'errors' => $model->errors];
        }
        return $model->getErrors();
    }

    public function actionDelete($id)
    {
        $model = MsCustomer::findOne(['customerID' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException("Customer not found.");
        }
        if ($model->delete()) {
            return ['status' => 'success', 'message' => 'Customer deleted successfully', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete customer', 'errors' => $model->errors];
        }
    }
}
