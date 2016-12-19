<?php

namespace frontend\models\maps;

use Yii;


use common\models\maps\AqMapPoints;

class MapPoints extends AqMapPoints
{
    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        return true;
    }
}