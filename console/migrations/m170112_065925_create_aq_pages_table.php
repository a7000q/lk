<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_pages`.
 */
class m170112_065925_create_aq_pages_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aq_pages', [
            'id' => $this->primaryKey(),
            'id_category' => $this->integer(),
            'name' => $this->string(),
            'rus_name' => $this->string(),
            'sort' => $this->integer()
        ]);

        $this->createIndex('idx_aq_pages_id_category', 'aq_pages', 'id_category');
        $this->addForeignKey('fk_aq_pages_id_category', 'aq_pages', 'id_category', 'aq_category', 'id');
    }


    public function down()
    {
        $this->dropTable('aq_pages');
    }
}
