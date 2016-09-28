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
}