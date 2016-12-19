<?php


namespace frontend\models\categoryes;

use frontend\models\maps\Maps;
use frontend\models\tables\Tables;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Categoryes extends \common\models\category\AqCategory
{
    public function getMenuItems()
    {
        $tables = $this->tables;
        $maps = $this->maps;

        $result = ArrayHelper::getColumn($tables, function($model){
           if ($model->isGeneral())
                return [
                   'label' => $model->rus_name,
                   'url' => ['table/index', 'id' => $model->id]
               ];
            else
                return false;
        });

        $result = ArrayHelper::merge($result, ArrayHelper::getColumn($maps, function($model){
            if ($model->isGeneral())
                return [
                    'label' => $model->name,
                    'url' => ['map/index', 'id' => $model->id]
                ];
            else
                return false;
        }));


        return array_filter($result);
    }

    public function getTables()
    {
        return $this->hasMany(Tables::className(), ['id_category' => 'id']);
    }

    public function getMaps()
    {
        return $this->hasMany(Maps::className(), ['id_category' => 'id']);
    }

}