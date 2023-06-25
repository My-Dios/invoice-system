<?php
namespace app\components;

use Yii;
use DateTime;
use DateTimeZone;
use yii\helpers\ArrayHelper;
use app\components\AppHelper;

class ResponsesHelper{
    public static function getResponseIndex($model, $limit = 5) {
        $request = Yii::$app->getRequest();
        $baseUrl = $request->getHostInfo() . $request->getBaseUrl();
        $currentUrl = $baseUrl . $request->getUrl();
        $timestamp = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
        $statusCode = Yii::$app->response->getStatusCode();
        $statusMessage = Yii::$app->response->statusText;
        $totalCount = count($model);
        $actualLimit = min($limit, $totalCount);
        $totalPages = ceil($totalCount / $actualLimit);
        $currentPage = Yii::$app->request->get('page', 1);
        $currentPage = max(1, min($totalPages, $currentPage));
        $startIndex = ($currentPage - 1) * $actualLimit;
        $slicedModel = array_slice($model, $startIndex, $actualLimit);
        $nextPageUrl = null;
        if ($currentPage < $totalPages) {
            $nextPage = $currentPage + 1;
            $nextPageUrl = AppHelper::buildUrlWithPage($currentUrl, $nextPage);
        }
        $prevPageUrl = null;
        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $prevPageUrl = AppHelper::buildUrlWithPage($currentUrl, $prevPage);
        }
        $response = [
            'path' => $currentUrl,
            'timeStamp' => $timestamp,
            'statusCode' => $statusCode,
            'message' => $statusMessage,
            'results' => [
                'page' => $currentPage,
                'limit' => $actualLimit,
                'count' => $totalCount,
                'data' => ArrayHelper::toArray($slicedModel),
                'next' => $nextPageUrl,
                'prev' => $prevPageUrl,
            ],
        ];
        return $response;
    }

    public static function getResponseView($model, $name) {
        $request = Yii::$app->getRequest();
        $baseUrl = $request->getHostInfo() . $request->getBaseUrl();
        $currentUrl = $baseUrl . $request->getUrl();
        $timestamp = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
        if ($model === null) {
            $response = [
                'path' => $currentUrl,
                'timeStamp' => $timestamp,
                'results' => [
                    'status' => 'failed',
                    'message' => $name . ' ' . 'not found',
                ],
            ];
        } else {
            $response = [
                'path' => $currentUrl,
                'timeStamp' => $timestamp,
                'results' => [
                    'status' => 'success',
                    'data' => ArrayHelper::toArray($model),
                ],
            ];
        }
        return $response;
    }
    
}    