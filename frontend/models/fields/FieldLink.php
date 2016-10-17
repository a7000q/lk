<?php

namespace frontend\models\fields;


use common\models\fields\AqFieldLink;
use yii\helpers\ArrayHelper;
use yii\db\Query;

class FieldLink extends AqFieldLink
{
    public function getDataArray()
    {
        $table_name = $this->fieldRef->table->name;
        $field_ref = $this->fieldRef->name;
        $field_visible = $this->fieldVisible->name;

        $data = (new Query())->select([$field_ref, $field_visible])->from($table_name)->all();

        return ArrayHelper::map($data, $field_ref, $field_visible);
    }
}