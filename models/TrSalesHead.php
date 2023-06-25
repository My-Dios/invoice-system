<?php

namespace app\models;

use yii\db\ActiveRecord;
use DateTime;
use DateTimeZone;
use yii\behaviors\TimestampBehavior;

class TrSalesHead extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tr_saleshead}}';
    }

    public static function primaryKey()
    {
        return ['salesNum'];
    }

    public function rules()
    {
        return [
            [['salesNum', 'subTotal', 'taxTotal', 'grandTotal'], 'required'],
            [['subTotal', 'taxTotal', 'grandTotal'], 'double'],
            [['salesNum'], 'string', 'max' => 255],
            [['statusInvoice'], 'string', 'max' => 255],
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
            'subTotal' => 'Sub Total',
            'taxTotal' => 'Tax Total',
            'grandTotal' => 'Grand Total',
            'statusInvoice' => 'Invoice Status',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }

    public function getInvoice()
    {
        return $this->hasOne(TrInvoice::class, ['salesNum' => 'salesNum']);
    }
}
