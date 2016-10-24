<?php

namespace backend\models\fields;


use common\models\fields\AqFieldLink;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class FieldLink extends AqFieldLink
{
    public function getRefTable()
    {
        return $this->fieldRef->table;
    }

    public function getDataArray()
    {
        $table_name = $this->fieldRef->table->name;
        $field_ref = $this->fieldRef->name;
        $field_visible = $this->fieldVisible->name;

        if ($this->fieldVisible->type->name == "link")
            return $this->fieldVisible->typeLink->dataArray;

        $data = (new Query())->select([$field_ref, $field_visible])->from($table_name)->all();

        return ArrayHelper::map($data, $field_ref, $field_visible);
    }
}