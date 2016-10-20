<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_filters`.
 */
class m161018_141533_create_aq_filters_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_filters', [
            'id' => $this->primaryKey(),
            'id_table' => $this->integer(),
            'id_field' => $this->integer(),
            'value' => $this->string()
        ]);

        $this->createIndex('idx-aq_filters-id_field', 'aq_filters', 'id_field');
        $this->addForeignKey('fk-aq_filters-id_field', 'aq_filters', 'id_field', 'aq_fields', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx-aq_filters-id_table', 'aq_filters', 'id_table');
        $this->addForeignKey('fk-aq_filters-id_table', 'aq_filters', 'id_table', 'aq_tables', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_filters');
    }
}
