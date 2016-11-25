<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_buttons`.
 */
class m161123_113616_create_aq_buttons_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aq_buttons', [
            'id' => $this->primaryKey(),
            'id_table' => $this->integer(),
            'name' => $this->string(),
            'type' => $this->string()
        ]);

        $this->createIndex("idx-aq_buttons-id_table", "aq_buttons", "id_table");
        $this->addForeignKey("fk-aq_buttons-id_table", "aq_buttons", "id_table", "aq_tables", "id", "CASCADE", "CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('aq_buttons');
    }
}
