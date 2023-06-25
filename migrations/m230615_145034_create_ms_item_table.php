<?php

use yii\db\Migration;

class m230615_145034_create_ms_item_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%ms_item}}', [
            'itemID' => $this->char(36)->notNull(),
            'itemName' => $this->string()->notNull(),
            'price' => $this->decimal(14, 4)->defaultValue(0.0000),
            'createdDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'editedDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%ms_item}}');
    }
}
