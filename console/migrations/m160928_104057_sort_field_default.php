<?php

use yii\db\Migration;

class m160928_104057_sort_field_default extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('aq_tables', 'sort');
        $this->addColumn('aq_tables', 'sort', $this->integer()->defaultValue(500)->notNull());
        $this->dropColumn('aq_fields', 'sort');
        $this->addColumn('aq_fields', 'sort', $this->integer()->defaultValue(500)->notNull());
    }

    public function safeDown()
    {
        echo "m160928_104057_sort_field_default cannot be reverted.\n";

        return true;
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
