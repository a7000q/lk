<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_buttons_scripts`.
 */
class m161124_130951_create_aq_buttons_scripts_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aq_buttons_scripts', [
            'id' => $this->primaryKey(),
            'id_button' => $this->integer(),
            'type' => $this->string(),
            'code' => $this->string(),
        ]);

        $this->createIndex("idx-aq_buttons_scripts-id_button", "aq_buttons_scripts", "id_button");
        $this->addForeignKey('fk-aq_buttons_scripts-id_table', "aq_buttons_scripts", "id_button", "aq_buttons", "id", "CASCADE", "CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('aq_buttons_scripts');
    }
}
