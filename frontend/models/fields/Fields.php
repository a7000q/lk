<?php


namespace frontend\models\fields;

use yii\helpers\ArrayHelper;
use Yii;

class Fields extends \common\models\fields\AqFields
{
    private function isUpdate()
    {
        if (!Yii::$app->user->can($this->getPermissionName('update')))
            return false;

        return true;
    }

    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        return true;
    }


}