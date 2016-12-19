<?php

namespace backend\models\category;

use backend\models\maps\Maps;
use backend\models\tables\Tables;
use yii\data\ActiveDataProvider;


class Category extends \common\models\category\AqCategory
{
    public function getTablesDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Tables::find()->where(['id_category' => $this->id])
        ]);
    }

    public function getMapsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => Maps::find()->where(['id_category' => $this->id])
        ]);
    }
}