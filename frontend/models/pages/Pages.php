<?php

namespace frontend\models\pages;


use common\models\pages\AqPages;
use Yii;

class Pages extends AqPages
{
    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        return true;
    }
}