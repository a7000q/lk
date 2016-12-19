<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_maps`.
 */
class m161215_061757_create_aq_maps_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_maps', [
            'id' => $this->primaryKey(),
            'id_category' => $this->integer(),
            'name' => $this->string(),
        ]);

        $this->createIndex("idx-aq_maps-id_category", "aq_maps", "id_category");
        $this->addForeignKey("fk-aq_maps-id_category", "aq_maps", "id_category", "aq_category", "id");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_maps');
    }
}
