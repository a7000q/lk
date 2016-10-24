<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_field_scripts`.
 */
class m161021_130224_create_aq_field_scripts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_field_scripts', [
            'id' => $this->primaryKey(),
            'id_field' => $this->integer(),
            'type' => $this->text(),
            'code' => $this->text(),
        ]);

        $this->createIndex('idx-aq_fields-id_field', 'aq_field_scripts', 'id_field');
        $this->addForeignKey('fk-aq_field_scripts-id_field', 'aq_field_scripts', 'id_field', 'aq_fields', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_field_scripts');
    }
}
