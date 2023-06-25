<?php

use yii\db\Migration;

class m230615_144636_create_ms_customer_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%ms_customer}}', [
            'customerID' => $this->char(36)->notNull(),
            'customerName' => $this->string()->notNull(),
            'detailAddress' => $this->string(),
            'email' => $this->string(),
            'mobilePhone' => $this->string(),
            'createdDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'editedDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%ms_customer}}');
    }
}
