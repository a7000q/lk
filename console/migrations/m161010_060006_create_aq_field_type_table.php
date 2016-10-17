<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_field_type`.
 */
class m161010_060006_create_aq_field_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_field_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_field_type');
    }
}
