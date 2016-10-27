<?php
namespace backend\models\tables;


use backend\models\fields\Fields;
use common\models\tables\AqTableLink;
use yii\helpers\ArrayHelper;

class TableLink extends AqTableLink
{
    public function getTablesArray()
    {
        $tables = Tables::find()->all();
        return $tables;
    }

    public function getFieldRefArray()
    {
        $fields = Fields::find()->where(['id_table' => $this->id_table_ref])->all();
        return ArrayHelper::map($fields, 'id', 'rus_name');
    }

    static public function newTableLink($id)
    {
        $table_link = new TableLink(['id_table' => $id]);
        $table_link->save();
    }

    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }

    public function getTable()
    {
        return $this->hasOne(Tables::className(), ['id' => 'id_table']);
    }

    public function getFieldRef()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field_ref']);
    }

    public function getTableRef()
    {
        return $this->hasOne(Tables::className(), ['id' => 'id_table_ref']);
    }
}