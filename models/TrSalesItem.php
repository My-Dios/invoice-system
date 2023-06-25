<?php

namespace app\models;

use yii\db\ActiveRecord;

class TrSalesItem extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tr_salesitem}}';
    }

    public static function primaryKey()
    {
        return ['salesNum'];
    }

    public function rules()
    {
        return [
            [['itemID', 'salesNum', 'qty', 'price', 'inclusivePrice','tax', 'taxValue','total'], 'required'],
            [['price', 'inclusivePrice','tax', 'taxValue','total'], 'double'],
            [['itemID', 'salesNum', 'qty'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itemID' => 'Item ID',
            'salesNum' => 'Sales Number',
            'price' => 'Price',
            'inclusivePrice' => 'Inclusive Price',
            'qty' => 'Quantity',
            'tax' => 'Tax',
            'taxValue' => 'Tax Value',
            'total' => 'Total',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }

    public function getInvoice()
    {
        return $this->hasOne(TrInvoice::class, ['salesNum' => 'salesNum']);
    }

    public function getItem()
    {
        return $this->hasOne(MsItem::class, ['itemID' => 'itemID']);
    }
}
