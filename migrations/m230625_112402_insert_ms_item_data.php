<?php

use yii\db\Migration;
use app\models\MsItem;

class m230625_112402_insert_ms_item_data extends Migration
{
    public function safeUp()
    {        
        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Demon Hunter Sword',
            'price' => 1958.4100,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Sea Halberd',
            'price' => 1973.4500,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Corrosion Scythe',
            'price' => 1839.8200,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Malefic Roar',
            'price' => 1849.5600,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Haas’s Claws',
            'price' => 1627.4300,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Berserker’s Fury',
            'price' => 2108.4200,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Endless Battle',
            'price' => 2219.4700,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Windtalker',
            'price' => 1675.2200,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Scarlet Phantom',
            'price' => 1812.6100,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_item}}', [
            'itemID' => 'ITM-' . MsItem::getIncrementedId(),
            'itemName' => 'Blade of the Heptaseas',
            'price' => 2018.1000,
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        
    }

    public function safeDown()
    {
        $this->delete('{{%ms_item}}', []);
    }

    
}
