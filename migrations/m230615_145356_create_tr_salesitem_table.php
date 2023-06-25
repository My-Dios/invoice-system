<?php

use yii\db\Migration;

class m230615_145356_create_tr_salesitem_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%tr_salesitem}}', [
            'id' => $this->primaryKey(),
            'salesNum' => $this->string()->notNull(),
            'itemID' => $this->char(36)->notNull(),
            'qty' => $this->decimal(14, 4)->defaultValue(0.0000),
            'price' => $this->decimal(14, 4)->defaultValue(0.0000),
            'inclusivePrice' => $this->decimal(14, 4)->defaultValue(0.0000),
            'tax' => $this->decimal(14, 4)->defaultValue(0.0000),
            'taxValue' => $this->decimal(14, 4)->defaultValue(0.0000),
            'total' => $this->decimal(14, 4)->defaultValue(0.0000),
            'createdDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'editedDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%tr_salesitem}}');
    }
}
