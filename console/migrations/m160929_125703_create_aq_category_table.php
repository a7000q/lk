<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_category`.
 */
class m160929_125703_create_aq_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->integer()->defaultValue(500),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_category');
    }
}
