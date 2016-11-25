<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_buttons_type`.
 */
class m161124_060616_create_aq_buttons_type_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aq_buttons_type', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('aq_buttons_type');
    }
}
