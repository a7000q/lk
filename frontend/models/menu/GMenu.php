<?php
/**
 * Created by PhpStorm.
 * User: Раиль
 * Date: 29.09.2016
 * Time: 10:09
 */

namespace frontend\models\menu;


use yii\base\Model;
use frontend\models\tables\Tables;
use yii\helpers\ArrayHelper;

class GMenu extends Model
{
    static public function getList()
    {
        $tables = Tables::find()->all();

        $result[] = ['label' => '<div class="sidebar-toggler"> </div>'];

        foreach ($tables as $table)
            $result[] = [
                'label' => $table->rus_name,
                'url' => ['table/index', 'id' => $table->id]
            ];

        return $result;
    }
}