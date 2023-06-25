<?php

namespace app\controllers;

use Yii;
use app\models\TrSalesHead;
use app\models\MsCustomer;
use app\models\MsItem;
use app\models\TrInvoice;
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
        $invoices = TrInvoice::find()->all();
        $response = [];
        foreach ($invoices as $invoice) {
            $salesNum = $invoice->salesNum;
            $customer = MsCustomer::findOne(['customerID' => $invoice->customerID]);
            if ($customer === null) {
                throw new Exception('Customer with ID ' . $invoice->customerID . ' not found.');
            }
            $items = [];
            $salesItemsBySalesNum = TrSalesItem::findAll(['salesNum' => $salesNum]);
            foreach ($salesItemsBySalesNum as $salesItem) {
                $item = MsItem::findOne(['itemID' => $salesItem->itemID]);
                if ($item === null) {
                    throw new Exception('Item with ID ' . $salesItem->itemID . ' not found.');
                }
                $items[] = [
                    'itemID' => $salesItem->itemID,
                    'itemName' => $item->itemName,
                    'price' => $salesItem->price,
                    'qty' => $salesItem->qty,
                    'taxValue' => $salesItem->taxValue,
                    'inclusivePrice' => $salesItem->inclusivePrice,
                    'total' => $salesItem->total,
                ];
            }
            $salesHead = TrSalesHead::findOne(['salesNum' => $salesNum]);
            if ($salesHead === null) {
                throw new Exception('Sales head with salesNum ' . $salesNum . ' not found.');
            }
            $model[] = [
                'salesNum' => $salesNum,
                'customerID' => $customer->customerID,
                'customerName' => $customer->customerName,
                'email' => $customer->email,
                'mobilePhone' => $customer->mobilePhone,
                'detailAddress' => $customer->detailAddress,
                'subject' => $invoice->subject,
                'issueDate' => $invoice->issueDate,
                'dueDate' => $invoice->dueDate,
                'tax' => "11%",
                'items' => $items,
                'subTotal' => $salesHead->subTotal,
                'taxTotal' => $salesHead->taxTotal,
                'grandTotal' => $salesHead->grandTotal,
                'statusInvoice' => $salesHead->statusInvoice,
                'createdDate' => $salesHead->createdDate,
                'editedDate' => $salesHead->editedDate,
            ];
        }
        $response = ResponsesHelper::getResponseIndex($model);
        return $response;
    }

    public function actionView($salesNum)
    {
        $invoice = TrInvoice::findOne(['salesNum' => $salesNum]);
        if ($invoice === null) {
            throw new Exception('Invoice with salesNum ' . $salesNum . ' not found.');
        }
        $customer = MsCustomer::findOne(['customerID' => $invoice->customerID]);
        if ($customer === null) {
            throw new Exception('Customer with ID ' . $invoice->customerID . ' not found.');
        }
        $items = [];
        $salesItemsBySalesNum = TrSalesItem::findAll(['salesNum' => $salesNum]);
        foreach ($salesItemsBySalesNum as $salesItem) {
            $item = MsItem::findOne(['itemID' => $salesItem->itemID]);

            if ($item === null) {
                throw new Exception('Item with ID ' . $salesItem->itemID . ' not found.');
            }
            $items[] = [
                'itemID' => $salesItem->itemID,
                'itemName' => $item->itemName,
                'price' => $salesItem->price,
                'qty' => $salesItem->qty,
                'taxValue' => $salesItem->taxValue,
                'inclusivePrice' => $salesItem->inclusivePrice,
                'total' => $salesItem->total,
            ];
        }
        $salesHead = TrSalesHead::findOne(['salesNum' => $salesNum]);
        if ($salesHead === null) {
            throw new Exception('Sales head with salesNum ' . $salesNum . ' not found.');
        }
        $model = [
            'salesNum' => $salesNum,
            'customerID' => $customer->customerID,
            'customerName' => $customer->customerName,
            'email' => $customer->email,
            'mobilePhone' => $customer->mobilePhone,
            'detailAddress' => $customer->detailAddress,
            'subject' => $invoice->subject,
            'issueDate' => $invoice->issueDate,
            'dueDate' => $invoice->dueDate,
            'tax' => "11%",
            'items' => $items,
            'subTotal' => $salesHead->subTotal,
            'taxTotal' => $salesHead->taxTotal,
            'grandTotal' => $salesHead->grandTotal,
            'statusInvoice' => $salesHead->statusInvoice,
            'createdDate' => $salesHead->createdDate,
            'editedDate' => $salesHead->editedDate,
        ];
        $response = ResponsesHelper::getResponseView($model, 'Transaction');
        return $response;
    }

    public function actionDelete($salesNum)
    {
        if ($salesNum === null) {
            throw new BadRequestHttpException('Missing required parameter: salesNum');
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            TrSalesItem::deleteAll(['salesNum' => $salesNum]);
            TrSalesHead::deleteAll(['salesNum' => $salesNum]);
            TrInvoice::deleteAll(['salesNum' => $salesNum]);
            $transaction->commit();
            return ['status' => 'success', 'message' => 'Transaction deleted successfully'];
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ['status' => 'error', 'message' => 'An error occurred: ' . $ex->getMessage()];
        }
    }

    public function actionUpdateTransaction($salesNum)
    {
        if ($salesNum === null) {
            throw new BadRequestHttpException('Missing required parameter: salesNum');
        }
        $request = Yii::$app->request->post();
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $invoice = TrInvoice::findOne(['salesNum' => $salesNum]);
            if ($invoice === null) {
                throw new Exception('Invoice with salesNum ' . $salesNum . ' not found.');
            }
            $invoice->customerID = $request['customerID'];
            $invoice->subject = $request['subject'];
            $invoice->issueDate = $request['issueDate'];
            $invoice->dueDate = $request['dueDate'];
            if (!$invoice->save()) {
                throw new Exception('Failed to update TrInvoice.');
            }
            TrSalesItem::deleteAll(['salesNum' => $salesNum]);
            $itemIDs = explode(', ', trim($request['itemID'][0], '[]'));
            $qtys = explode(', ', trim($request['qty'][0], '[]'));
            foreach ($itemIDs as $key => $itemID) {
                $item = MsItem::findOne(['itemID' => $itemID]);
                if ($item === null) {
                    throw new Exception('Item with ID ' . $itemID . ' not found.');
                }
                $salesItem = new TrSalesItem();
                $salesItem->qty = (string) $qtys[$key]; 
                $salesItem->tax = 11; 
                $salesItem->salesNum = $invoice->salesNum;
                $salesItem->itemID = $itemID;
                $salesItem->price = (double) $item->price;
                $salesItem->taxValue = ($salesItem->price * 0.11);  
                $salesItem->inclusivePrice = (double) $item->price + $salesItem->taxValue;
                $salesItem->total = $salesItem->inclusivePrice * $salesItem->qty;
                if (!$salesItem->save()) {
                    $errors = $salesItem->getErrors();
                    $errorMessage = '';
                    foreach ($errors as $attribute => $errorMessages) {
                        $errorMessage .= $attribute . ': ' . implode(', ', $errorMessages) . "\n";
                    }
                    throw new Exception('Failed to save TrSalesItem. Errors: ' . $errorMessage);
                }
            }
            $salesHead = TrSalesHead::findOne(['salesNum' => $salesNum]);
            if ($salesHead === null) {
                throw new Exception('SalesHead with salesNum ' . $salesNum . ' not found.');
            }
            $salesHead->subTotal = $invoice->calculateSubTotal($request);
            $salesHead->taxTotal = $invoice->calculateTaxTotal($request);
            $salesHead->grandTotal = $invoice->calculateGrandTotal($salesHead->subTotal, $salesHead->taxTotal);
            $salesHead->statusInvoice = $invoice->setStatusInvoice($request['issueDate'], $request['dueDate']);
            if (!$salesHead->save()) {
                $errors = $salesHead->getErrors();
                $errorMessage = '';
                foreach ($errors as $attribute => $errorMessages) {
                    $errorMessage .= $attribute . ': ' . implode(', ', $errorMessages) . "\n";
                }
                throw new Exception('Failed to update TrSalesHead. Errors: ' . $errorMessage);
            }
            $transaction->commit();
            return ['status' => 'success', 'message' => 'Transaction updated successfully'];
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ['status' => 'error', 'message' => 'An error occurred: ' . $ex->getMessage()];
        }
    }


    public function actionCreateTransaction()
    {   
        $request = Yii::$app->request->post();
        $customerID = $request['customerID'];
        $subject = $request['subject'];
        $issueDate = $request['issueDate'];
        $dueDate = $request['dueDate'];
        $customerIDValidation = MsCustomer::findOne(['customerID' => $customerID]);
        if ($customerIDValidation === null) {
            return ['status' => 'error', 'message' => 'Customer with ID ' . $customerID . ' not found.'];
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $invoice = new TrInvoice();
            $invoice->customerID = $customerID;
            $invoice->subject = $subject;
            $invoice->issueDate = $issueDate;
            $invoice->dueDate = $dueDate;
            if (!$invoice->save()) {
                throw new Exception('Failed to save TrInvoice.');
            }
            $itemIDs = explode(', ', trim($request['itemID'][0], '[]'));
            $qtys = explode(', ', trim($request['qty'][0], '[]'));
            foreach ($itemIDs as $key => $itemID) {
                $item = MsItem::findOne(['itemID' => $itemID]);
                if ($item === null) {
                    throw new Exception('Item with ID ' . $itemID . ' not found.');
                }
                $salesItem = new TrSalesItem();
                $salesItem->qty = (string) $qtys[$key]; 
                $salesItem->tax = 11; 
                $salesItem->salesNum = $invoice->salesNum;
                $salesItem->itemID = $itemID;
                $salesItem->price = (double) $item->price;
                $salesItem->taxValue = ($salesItem->price * 0.11);  
                $salesItem->inclusivePrice = round((double) $item->price + $salesItem->taxValue);
                $salesItem->total = $salesItem->inclusivePrice * $salesItem->qty;
                if (!$salesItem->save()) {
                    $errors = $salesItem->getErrors();
                    $errorMessage = '';
                    foreach ($errors as $attribute => $errorMessages) {
                        $errorMessage .= $attribute . ': ' . implode(', ', $errorMessages) . "\n";
                    }
                    throw new Exception('Failed to save TrSalesItem. Errors: ' . $errorMessage);
                }
            }
            $salesHead = new TrSalesHead();
            $salesHead->salesNum = $invoice->salesNum;
            $salesHead->subTotal = $invoice->calculateSubTotal($request);
            $salesHead->taxTotal = $invoice->calculateTaxTotal($request);
            $salesHead->grandTotal = $invoice->calculateGrandTotal($salesHead->subTotal, $salesHead->taxTotal);
            $salesHead->statusInvoice = $invoice->setStatusInvoice($issueDate, $dueDate);
            if (!$salesHead->save()) {
                $errors = $salesHead->getErrors();
                $errorMessage = '';
                foreach ($errors as $attribute => $errorMessages) {
                    $errorMessage .= $attribute . ': ' . implode(', ', $errorMessages) . "\n";
                }
                throw new Exception('Failed to save TrSalesHead. Errors: ' . $errorMessage);
            }
            $transaction->commit();
            return ['status' => 'success', 'message' => 'Transaction created successfully'];
        } catch (Exception $ex) {
            $transaction->rollBack();
            return ['status' => 'error', 'message' => 'An error occurred: ' . $ex->getMessage()];
        }
    }
}

