<?php


namespace frontend\models\tables;

use frontend\models\fields\Fields;
use yii\helpers\ArrayHelper;
use Yii;

class Tables extends \common\models\tables\AqTables
{
    public function getGridViewFieldsArray()
    {
        $fields = $this->fields;

        $result = ArrayHelper::getColumn($fields, function($element){
            if ($element->isGeneral())
                return $element->gridViewColumn;
        });

        $result = array_filter($result);

        if (count($result) == 0)
            return false;

        if ($this->isView() or $this->isDelete())
            $result[] = [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view}{delete}',
                'visibleButtons' => [
                    'view' => $this->isView(),
                    'delete' => $this->isDelete()
                ],
                'urlCreator' => function($action, $model, $key, $index){
                       return [$action, 'id' => $model->id, 'id_table' => $this->id];
                }
            ];

        return $result;
    }

    public function getEditGridViewColumns($link)
    {
        $fields = $this->fields;

        $result = ArrayHelper::getColumn($fields, function($element) use ($link){
            if ($element->isGeneral() and ($element->id != $link->id_field_ref))
                return $element->editGridViewColumn;
        });

        $result = array_filter($result);

        if (count($result) == 0)
            return false;

        if ($this->isDelete())
            $result[] = [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}',
                'visibleButtons' => [
                    'delete' => $this->isDelete()
                ],
                'urlCreator' => function($action, $model, $key, $index){
                    return [$action, 'id' => $model->id, 'id_table' => $this->id];
                }
            ];

        return $result;
    }

    public function getDetailViewAttributesArray($model)
    {
        $fields = $this->fields;

        $result = ArrayHelper::getColumn($fields, function($element) use ($model){
            if ($element->isGeneral())
                return $element->getDetailViewAttributes($model);
        });

        $result = array_filter($result);

        if (count($result) == 0)
            return false;

        return $result;
    }

    public function getFields()
    {
        return $this->hasMany(Fields::className(), ['id_table' => 'id'])->orderBy('sort');
    }

    public function getTableLinks()
    {
        return $this->hasMany(TableLink::className(), ['id_table' => 'id']);
    }

    public function isUpdate()
    {
        if (!Yii::$app->user->can($this->getPermissionName('update')))
            return false;

        return true;
    }

    public function isView()
    {
        if (!Yii::$app->user->can($this->getPermissionName('view')))
            return false;

        return true;
    }

    public function isDelete()
    {
        if (!Yii::$app->user->can($this->getPermissionName('delete')))
            return false;

        return true;
    }

    public function isCreate()
    {
        if (!Yii::$app->user->can($this->getPermissionName('create')))
            return false;

        return true;
    }

    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        if (!$this->getGridViewFieldsArray())
            return false;

        return true;
    }


}