<?php

use yii\db\Migration;

/**
 * Handles the creation of table `aq_map_points`.
 */
class m161215_062006_create_aq_map_points_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('aq_map_points', [
            'id' => $this->primaryKey(),
            'id_map' => $this->integer(),
            'name' => $this->string(),
            'description' => $this->string(),
            'value' => $this->string(),
        ]);

        $this->createIndex('idx-aq_map_points-id_map', "aq_map_points", 'id_map');
        $this->addForeignKey('fk-aq_map_points-id_map', "aq_map_points", "id_map", "aq_maps", "id", "CASCADE", "CASCADE");
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('aq_map_points');
    }
}
