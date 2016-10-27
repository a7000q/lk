<?php

namespace frontend\models\tables;


use common\models\tables\AqTableLink;
use frontend\models\fields\Fields;

class TableLink extends AqTableLink
{
    public function getTable()
    {
        return $this->hasOne(Tables::className(), ['id' => 'id_table']);
    }

    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }

    public function getTableRef()
    {
        return $this->hasOne(Tables::className(), ['id' => 'id_table_ref']);
    }

    public function getFieldRef()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field_ref']);
    }

}