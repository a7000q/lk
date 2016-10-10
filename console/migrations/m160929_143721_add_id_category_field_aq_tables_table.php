<?php

use yii\db\Migration;

class m160929_143721_add_id_category_field_aq_tables_table extends Migration
{
    public function safeUp()
    {
        $this->addColumn('aq_tables', 'id_category', $this->integer()->notNull());
        $this->createIndex('idx-aq_tables-id_category', 'aq_tables', 'id_category');
        $this->addForeignKey('fk-aq_tables-id_category', 'aq_tables', 'id_category', 'aq_category', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-aq_tables-id_category', 'aq_tables');
        $this->dropIndex('idx-aq_tables-id_category', 'aq_tables');
        $this->dropColumn('aq_tables', 'id_category');
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
