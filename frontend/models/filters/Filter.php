<?php

namespace frontend\models\filters;


use common\models\filters\AqFilters;
use frontend\models\fields\Fields;

class Filter extends AqFilters
{
    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }
}