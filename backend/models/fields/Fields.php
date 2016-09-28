<?php

namespace backend\models\fields;

class Fields extends \common\models\fields\AqFields
{
    static public function newField($id_table)
    {
        $model = new Fields();
        $model->id_table = $id_table;
        $model->save();
    }
}