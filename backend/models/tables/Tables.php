<?php

namespace backend\models\tables;

use yii\data\ActiveDataProvider;
use backend\models\fields\Fields;


class Tables extends \common\models\tables\AqTables
{
    public function getFieldsDataProvider()
    {
        return new ActiveDataProvider(
            [
                'query' => Fields::find()->where(['id_table' => $this->id])
            ]
        );
    }

    static public function newTable($id_category)
    {
        $model = new Tables();
        $model->id_category = $id_category;
        $model->save();
    }
}