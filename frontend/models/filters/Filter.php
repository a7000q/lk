<?php

namespace frontend\models\filters;


use common\models\filters\AqFilters;
use frontend\models\fields\Fields;
use Yii;

class Filter extends AqFilters
{
    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }

    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        return true;
    }
}