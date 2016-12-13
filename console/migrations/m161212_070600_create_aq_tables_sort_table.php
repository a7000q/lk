<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_tables_sort`.
 */
class m161212_070600_create_aq_tables_sort_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_tables_sort', [
            'id' => $this->primaryKey(),
            'id_table' => $this->integer(),
            'id_field' => $this->integer(),
            'sort' => $this->integer()->defaultValue(500),
            'action' => $this->integer()->defaultValue(1),
        ]);

        $this->createIndex('aq_tables_sort-id_table', 'aq_tables_sort', 'id_table');
        $this->createIndex('aq_tables_sort-id_field', 'aq_tables_sort', 'id_field');

        $this->addForeignKey('fk-aq_tables_sort-id_table', 'aq_tables_sort', 'id_table', 'aq_tables', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk-aq_tables_sort-id_field', 'aq_tables_sort', 'id_field', 'aq_fields', 'id', "CASCADE", "CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_tables_sort');
    }
}
