<?php

namespace frontend\models\fields;


use common\models\fields\AqFieldLink;
use yii\helpers\ArrayHelper;
use Yii;

class FieldLink extends AqFieldLink
{
    public function getDataArray()
    {
        $table = $this->fieldRef->table;
        $field_ref = $this->fieldRef->name;
        $field_visible = $this->fieldVisible->name;

        if ($this->fieldVisible->type->name == "link")
            return $this->fieldVisible->typeLink->dataArray;

        $class = $table->getClassName();
        $class::$tableBD = $table;
        $model = $class::find()->filterLimitationField(Yii::$app->user->id, $this->field->id)->filterLimitations(Yii::$app->user->id, $table->id)->all();

        return ArrayHelper::merge(['Выберите значение'], ArrayHelper::map($model, $field_ref, $field_visible));
    }

    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }

    public function getFieldRef()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field_ref']);
    }

    public function getFieldVisible()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field_visible']);
    }
}