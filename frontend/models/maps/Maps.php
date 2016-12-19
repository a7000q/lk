<?php

namespace frontend\models\maps;

use Yii;


use common\models\maps\AqMaps;

class Maps extends AqMaps
{
    public function getMapPoints()
    {
        return $this->hasMany(MapPoints::className(), ['id_map' => 'id']);
    }

    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        if (!$this->mapPoints)
            return false;

        return true;
    }
}