<?php

namespace backend\models\users;


use backend\models\fields\Fields;
use common\models\limitations\AqLimitations;
use yii\helpers\ArrayHelper;

class Limitations extends AqLimitations
{
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'field.rus_name' => 'Поле',
            'field.table.rus_name' => 'Таблица',
            'operand' => "Операнд",
            'value' => 'Значение',
            'valueField' => 'Значение'
        ]);
    }

    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }

    public function getValueField()
    {
        switch ($this->field->type->name)
        {
            case "integer":
                $result = $this->getIntegerValue();
                break;
            case "text":
                $result = $this->getTextValue();
                break;
            case "date":
                $result = $this->getDateValue();
                break;
            case "link":
                $result = $this->getLinkValue();
                break;
        }

        return $result;
    }

    private function getIntegerValue()
    {
        return $this->value;
    }

    private function getTextValue()
    {
        return $this->value;
    }

    private function getDateValue()
    {
        $field = $this->field;

        return date($field->typeDate->format, $this->value);
    }

    private function getLinkValue()
    {
        $field = $this->field;

        return $field->typeLink->dataArray[(int)$this->value];
    }
}