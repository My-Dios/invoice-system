<?php

namespace app\models;

use DateTime;
use DateTimeZone;
use yii\behaviors\TimestampBehavior;

class MsItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'ms_item';
    }

    public static function primaryKey()
    {
        return ['itemID'];
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

    public function rules()
    {
        return [
            [['itemName'], 'required'],
            [['itemName'], 'unique'],
            [['price'], 'integer'],
            [['createdDate', 'editedDate'], 'safe'],
            [['itemID'], 'default', 'value' => function ($model, $attribute) {
                return 'ITM-' . $this->getIncrementedId();
            }],
            [['itemID'], 'string', 'max' => 36],
            [['itemName'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'itemID' => 'Item ID',
            'itemName' => 'Item Name',
            'price' => 'Price',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->itemID = 'ITM-' . $this->getIncrementedId();
            $this->createdDate = date('Y-m-d H:i:s');
        }
        $this->editedDate = date('Y-m-d H:i:s');

        return parent::beforeSave($insert);
    }

    public static function getIncrementedId()
    {
        $maxId = static::find()
            ->select('itemID')
            ->orderBy(['CAST(SUBSTRING_INDEX(itemID, "-", -1) AS SIGNED)' => SORT_DESC])
            ->scalar();

        $maxIdNumber = $maxId ? (int)substr($maxId, strpos($maxId, '-') + 1) : 0;
        $newIdNumber = $maxIdNumber + 1;
        return $newIdNumber;
    }

    public function getSalesItem()
    {
        return $this->hasMany(TrInvoice::class, ['itemID' => 'itemID']);
    }
}
