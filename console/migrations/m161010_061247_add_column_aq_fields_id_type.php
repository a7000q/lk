<?php

use yii\db\Migration;

class m161010_061247_add_column_aq_fields_id_type extends Migration
{
    public function safeUp()
    {
        $this->addColumn('aq_fields', 'id_type', $this->integer());
        $this->createIndex('idx-aq_fields-id_type', 'aq_fields', 'id_type');
        $this->addForeignKey('fk-aq_fields-id_type', 'aq_fields', 'id_type', 'aq_field_type', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-aq_fields-id_type', 'aq_fields');
        $this->dropIndex('idx-aq_fields-id_type',  'aq_fields');
        $this->dropColumn('aq_fields', 'id_type');
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
