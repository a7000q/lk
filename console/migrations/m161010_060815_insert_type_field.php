<?php

use yii\db\Migration;

class m161010_060815_insert_type_field extends Migration
{
    public function safeUp()
    {
        $this->insert('aq_field_type', ['name' => 'integer']);
        $this->insert('aq_field_type', ['name' => 'text']);
        $this->insert('aq_field_type', ['name' => 'date']);
        $this->insert('aq_field_type', ['name' => 'link']);
    }

    public function safeDown()
    {
        $this->delete('aq_field_type', ['name' => 'integer']);
        $this->delete('aq_field_type', ['name' => 'text']);
        $this->delete('aq_field_type', ['name' => 'date']);
        $this->delete('aq_field_type', ['name' => 'link']);
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
