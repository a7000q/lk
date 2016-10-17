<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_field_link`.
 */
class m161010_105331_create_aq_field_link_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_field_link', [
            'id' => $this->primaryKey(),
            'id_field' => $this->integer(),
            'id_field_ref' => $this->integer(),
            'id_field_visible' => $this->integer(),
        ]);

        $this->createIndex('idx-aq_field_link-id_field', 'aq_field_link', 'id_field');
        $this->createIndex('idx-aq_field_link-id_field_visible', 'aq_field_link', 'id_field_visible');
        $this->createIndex('idx-aq_field_link-id_field_ref', 'aq_field_link', 'id_field_ref');

        $this->addForeignKey('fk-aq_field_link-id_field', 'aq_field_link', 'id_field', 'aq_fields', 'id', "CASCADE", "CASCADE");
        $this->addForeignKey('fk-aq_field_link-id_field_ref', 'aq_field_link', 'id_field_ref', 'aq_fields', 'id');
        $this->addForeignKey('fk-aq_field_link-id_field_visible', 'aq_field_link', 'id_field_visible', 'aq_fields', 'id');

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_field_link');
    }
}
