<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_field_date`.
 */
class m161010_084113_create_aq_field_date_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aq_field_date', [
            'id' => $this->primaryKey(),
            'id_field' => $this->integer(),
            'format' => $this->string(),
        ]);

        $this->createIndex('idx-aq_field_date-id_field', 'aq_field_date', 'id_field');
        $this->addForeignKey('fk-aq_field_date-id_field', 'aq_field_date', 'id_field', 'aq_fields', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('aq_field_date');
    }
}
