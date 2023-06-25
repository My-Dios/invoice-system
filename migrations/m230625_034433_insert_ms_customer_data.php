<?php

use yii\db\Migration;

class m230625_034433_insert_ms_customer_data extends Migration
{
    public function safeUp()
    {        
        $this->insert('{{%ms_customer}}', [
            'customerID' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'customerName' => 'Natalia',
            'detailAddress' => 'Jl. Petamburan Roamer Land Of Dawn',
            'email' => 'natalia@gmail.com',
            'mobilePhone' => '0895396788452',
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_customer}}', [
            'customerID' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'customerName' => 'Selena',
            'detailAddress' => 'Mid Jl Lord',
            'email' => 'selene@gmail.com',
            'mobilePhone' => '0896483966752',
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_customer}}', [
            'customerID' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'customerName' => 'Hilda',
            'detailAddress' => 'Jl Roamer Jantang',
            'email' => 'hilda@gmail.com',
            'mobilePhone' => '0896728966752',
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_customer}}', [
            'customerID' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'customerName' => 'Aldous',
            'detailAddress' => 'Jl Mid 5 Menit',
            'email' => 'aldous@gmail.com',
            'mobilePhone' => '0896728966752',
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_customer}}', [
            'customerID' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'customerName' => 'Hanabi',
            'detailAddress' => 'Jl Gold Exp Land',
            'email' => 'hanabi@gmail.com',
            'mobilePhone' => '0896735973752',
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{%ms_customer}}', [
            'customerID' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
            'customerName' => 'Saber',
            'detailAddress' => 'Jl Saber Roam',
            'email' => 'saber@gmail.com',
            'mobilePhone' => '0896797592752',
            'createdDate' => date('Y-m-d H:i:s'),
            'editedDate' => date('Y-m-d H:i:s'),
        ]);
    }

    public function safeDown()
    {
        $this->delete('{{%ms_customer}}', []);
    }
}
