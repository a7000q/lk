<?php

use yii\db\Migration;

class m161024_060508_add_type_calculation extends Migration
{
    public function up()
    {
        $this->insert("aq_field_type", ['name' => 'calculate']);
    }

    public function down()
    {
        $this->delete("aq_field_type", ["name" => "calculate"]);
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
