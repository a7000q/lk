<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_limitations`.
 */
class m161014_065028_create_aq_limitations_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_limitations', [
            'id' => $this->primaryKey(),
            'id_user' => $this->integer(),
            'id_field' => $this->integer(),
            'operand' => $this->text(),
            'value' => $this->text(),
        ]);

        $this->createIndex('idx-aq_limitations-id_user', 'aq_limitations', 'id_user');
        $this->addForeignKey('fk-aq_limitations-id_user', 'aq_limitations', 'id_user', 'user', 'id', "CASCADE", "CASCADE");

        $this->createIndex('idx-aq_limitations-id_field', 'aq_limitations', 'id_field');
        $this->addForeignKey('fk-aq_limitations-id_field', 'aq_limitations', 'id_field', 'aq_fields', 'id', "CASCADE", "CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_limitations');
    }
}
