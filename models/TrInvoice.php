<?php

namespace app\models;

use Yii;
use Exception;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use DateTime;
use DateTimeZone;

class TrInvoice extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tr_invoice}}';
    }

    
    public static function primaryKey()
    {
        return ['salesNum'];
    }
    
    public function rules()
    {
        return [
            [['customerID', 'subject', 'issueDate', 'dueDate'], 'required'],
            [['issueDate', 'dueDate', 'createdDate', 'editedDate'], 'safe'],
            [['customerID'], 'string', 'max' => 36],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'createdDate',
                'updatedAtAttribute' => 'editedDate',
                'value' => function () {
                    return (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
                },
            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'salesNum' => 'Sales Number',
            'customerID' => 'Customer ID',
            'subject' => 'Subject',
            'issueDate' => 'Issue Date',
            'dueDate' => 'Due Date',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $currentTime = time();
            $salesNum = 'IVC' . '-' . $currentTime;
            $this->salesNum = $salesNum;
        }
        return parent::beforeSave($insert);
    }

    public function calculateSubTotal($request)
    {
        $subtotal = 0;
        $itemIDs = explode(', ', trim($request['itemID'][0], '[]'));
        $qtys = explode(', ', trim($request['qty'][0], '[]'));
        foreach ($itemIDs as $key => $itemID) {
            $msItem = MsItem::findOne(['itemID' => $itemID]);
            if ($msItem) {
                $price = (double) $msItem->price;
                $qty = (double) $qtys[$key];

                $subtotal += $price * $qty;
            }
        }
        return $subtotal;
    }

    public function calculateTaxTotal($request)
    {
        $taxTotal = 0;
        $itemIDs = explode(', ', trim($request['itemID'][0], '[]'));
        $qtys = explode(', ', trim($request['qty'][0], '[]'));
        foreach ($itemIDs as $key => $itemID) {
            $msItem = MsItem::findOne(['itemID' => $itemID]);
            if ($msItem) {
                $price = (double) $msItem->price;
                $qty = (double) $qtys[$key];

                $tax = ($price * 0.11) * $qty;
                $taxTotal += $tax;
            }
        }
        return $taxTotal;
    }

    public function calculateGrandTotal($subTotal, $taxTotal)
    {
        $grandTotal = $subTotal + $taxTotal;
        return $grandTotal;
    }

    public function setStatusInvoice($issueDate, $dueDate)
    {
        $now = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $issueDateTime = new DateTime($issueDate, new DateTimeZone('Asia/Jakarta'));
        $dueDateTime = new DateTime($dueDate, new DateTimeZone('Asia/Jakarta'));
        if ($now >= $issueDateTime && $now <= $dueDateTime) {
            $statusInvoice = 'Active';
        } else {
            $statusInvoice = 'Expired';
        }
        return $statusInvoice;
    }



    public function getCustomer()
    {
        return $this->hasOne(MsCustomer::class, ['customerID' => 'customerID']);
    }

    public function getSalesHead()
    {
        return $this->hasOne(TrSalesHead::class, ['salesNum' => 'salesNum']);
    }

    public function getSalesItems()
    {
        return $this->hasMany(TrSalesItem::class, ['salesNum' => 'salesNum']);
    }
}
