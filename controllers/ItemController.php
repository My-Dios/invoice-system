<?php

namespace app\controllers;

use Yii;
use app\models\MsItem;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use app\components\ResponsesHelper;

class ItemController extends Controller
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
        $model = MsItem::find()->all();
        $response = ResponsesHelper::getResponseIndex($model);
        return $response;
    }

    public function actionView($id)
    {
        $model = MsItem::findOne(['itemID' => $id]);
        $response = ResponsesHelper::getResponseView($model, 'Item');
        return $response;
    }

    public function actionCreate()
    {
        $model = new MsItem();
        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->save()) {
            return ['status' => 'success', 'message' => 'Item created successfully', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to create item', 'errors' => $model->errors];
        }
    }

    public function actionUpdate($id)
    {
        $model = MsItem::findOne(['itemID' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException("Item not found.");
        }
        $model->load(Yii::$app->request->getBodyParams(), '');
        if ($model->save()) {
            return ['status' => 'success', 'message' => 'Item updated successfully', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to update item', 'errors' => $model->errors];
        }
    }

    public function actionDelete($id)
    {
        $model = MsItem::findOne(['itemID' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException("Item not found.");
        }
        if ($model->delete()) {
            return ['status' => 'success', 'message' => 'Item deleted successfully', 'data' => $model];
        } else {
            return ['status' => 'error', 'message' => 'Failed to delete item', 'errors' => $model->errors];
        }
    }
}
