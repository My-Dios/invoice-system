<?php

namespace app\models;

use Ramsey\Uuid\Uuid;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use DateTime;
use DateTimeZone;
use app\components\ResponsesHelper;
use yii\web\NotFoundHttpException;

class MsCustomer extends ActiveRecord
{
    public static function tableName()
    {
        return 'ms_customer';
    }

    public static function primaryKey()
    {
        return ['customerID'];
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
            [['customerName'], 'required'],
            [['email', 'customerID'], 'unique'],
            [['createdDate', 'editedDate'], 'safe'],
            [['customerID'], 'string', 'max' => 36],
            [['customerName', 'detailAddress', 'email', 'mobilePhone'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'customerID' => 'Customer ID',
            'customerName' => 'Customer Name',
            'detailAddress' => 'Detail Address',
            'email' => 'Email',
            'mobilePhone' => 'Mobile Phone',
            'createdDate' => 'Created Date',
            'editedDate' => 'Edited Date',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->customerID = Uuid::uuid4()->toString();
        }
        return parent::beforeSave($insert);
    }

    public function getInvoice()
    {
        return $this->hasMany(TrInvoice::class, ['customerID' => 'customerID']);
    }
}
