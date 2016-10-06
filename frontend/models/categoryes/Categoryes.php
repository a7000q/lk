<?php


namespace frontend\models\categoryes;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Categoryes extends \common\models\category\AqCategory
{
    public function getMenuItems()
    {
        $tables = $this->tables;

        $result = ArrayHelper::getColumn($tables, function($model){
           return [
               'label' => $model->rus_name,
               'url' => ['table/index', 'id' => $model->id]
           ];
        });

        return $result;
    }
}