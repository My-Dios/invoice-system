<?php

use yii\db\Migration;

class m230615_145645_create_tr_saleshead_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tr_saleshead}}', [
            'salesNum' => $this->string()->notNull(),
            'subTotal' => $this->decimal(14, 4)->defaultValue(0.0000),
            'taxTotal' => $this->decimal(14, 4)->defaultValue(0.0000),
            'grandTotal' => $this->decimal(14, 4)->defaultValue(0.0000),
            'statusInvoice' => $this->string(),
            'createdDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'editedDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%tr_saleshead}}');
    }
}
