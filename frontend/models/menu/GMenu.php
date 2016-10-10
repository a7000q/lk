<?php

namespace frontend\models\menu;


use yii\base\Model;
use frontend\models\categoryes\Categoryes;

class GMenu extends Model
{
    static public function getList()
    {
        $categoryes = Categoryes::find()->all();

        foreach ($categoryes as $category)
            if ($category->tables)
                $result[] = [
                    'label' => $category->name,
                    'items' => $category->menuItems
                ];

        return $result;
    }
}