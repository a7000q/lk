<?php

use yii\db\Migration;

class m161025_065632_add_show_page_summary_column extends Migration
{
    public function up()
    {
        $this->addColumn('aq_fields', 'page_summary', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
       $this->dropColumn("aq_fields", 'page_summary');
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
