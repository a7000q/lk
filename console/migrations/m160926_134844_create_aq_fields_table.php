<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_fields`.
 */
class m160926_134844_create_aq_fields_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_fields', [
            'id' => $this->primaryKey(),
            'id_table' => $this->integer(),
            'name' => $this->string(),
            'rus_name' => $this->string(),
            'sort' => $this->integer()
        ]);

        $this->createIndex('idx-fields-id_table', 'aq_fields', 'id_table');
        $this->addForeignKey('fk-fields-id_table', 'aq_fields', 'id_table', 'aq_tables', 'id', "CASCADE", "CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_fields');
    }
}
