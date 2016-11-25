<?php

use yii\db\Migration;

class m161125_070937_add_php_code_aq_buttons extends Migration
{
    public function up()
    {
        $this->addColumn("aq_buttons", "code", $this->string());
    }

    public function down()
    {
        $this->dropColumn("aq_buttons", "code");
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
