<?php


namespace frontend\models\tables;

use yii\helpers\ArrayHelper;

class Tables extends \common\models\tables\AqTables
{
    public function getGridViewFieldsArray()
    {
        $fields = $this->fields;

        $result = ArrayHelper::getColumn($fields, function($element){
            return $element->name;
        });

        $result[] = [
            'class' => 'kartik\grid\ActionColumn',
            'urlCreator' => function($action, $model, $key, $index){
                   return [$action, 'id' => $model->id, 'id_table' => $this->id];
            }
        ];

        return $result;
    }
}