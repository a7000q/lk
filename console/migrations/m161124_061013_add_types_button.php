<?php

use yii\db\Migration;

class m161124_061013_add_types_button extends Migration
{
    public function up()
    {
        $this->insert("aq_buttons_type", ['name' => 'pdf']);
    }

    public function down()
    {
        echo "m161124_061013_add_types_button cannot be reverted.\n";

        return false;
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
