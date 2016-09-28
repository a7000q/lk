<?php

use yii\db\Migration;

/**
 * Handles the creation for table `aq_tables`.
 */
class m160926_132721_create_aq_tables_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('aq_tables', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'rus_name' => $this->string(),
            'sort' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('aq_tables');
    }
}
