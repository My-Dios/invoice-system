<?php

use yii\db\Migration;

class m230615_144121_create_tr_invoice_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tr_invoice}}', [
            'salesNum' => $this->string()->notNull(),
            'customerID' => $this->char(36)->notNull(),
            'subject' => $this->string()->notNull(),
            'issueDate' => $this->dateTime()->notNull(),
            'dueDate' => $this->dateTime()->notNull(),
            'createdDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'editedDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%tr_invoice}}');
    }
}
