<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_table_link`.
 */
class m161026_065616_create_aq_table_link_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_table_link', [
            'id' => $this->primaryKey(),
            'id_table' => $this->integer(),
            'id_field' => $this->integer(),
            'id_table_ref' => $this->integer(),
            'id_field_ref' => $this->integer(),
        ]);

        $this->createIndex('idx-aq_table_link-id_table', 'aq_table_link', 'id_table');
        $this->createIndex('idx-aq_table_link-id_field', 'aq_table_link', 'id_field');
        $this->createIndex('idx-aq_table_link-id_table_ref', 'aq_table_link', 'id_table_ref');
        $this->createIndex('idx-aq_table_link-id_field_ref', 'aq_table_link', 'id_field_ref');

        $this->addForeignKey('fk-aq_table_id_table', 'aq_table_link', 'id_table', 'aq_tables', 'id');
        $this->addForeignKey('fk-aq_table_id_field', 'aq_table_link', 'id_field', 'aq_fields', 'id');
        $this->addForeignKey('fk-aq_table_id_table_ref', 'aq_table_link', 'id_table_ref', 'aq_tables', 'id');
        $this->addForeignKey('fk-aq_table_id_field_ref', 'aq_table_link', 'id_field_ref', 'aq_fields', 'id');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_table_link');
    }
}
