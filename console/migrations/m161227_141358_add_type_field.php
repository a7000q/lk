<?php

use yii\db\Migration;

class m161227_141358_add_type_field extends Migration
{
    public function safeUp()
    {
        $this->insert('aq_field_type', ['name' => 'password']);
    }

    public function safeDown()
    {
        $this->delete('aq_field_type', ['name' => 'password']);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
