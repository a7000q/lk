<?php


namespace frontend\models\fields;

use backend\models\fields\FieldScripts;
use kartik\detail\DetailView;
use kartik\editable\Editable;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use Yii;
use frontend\models\fields\FieldLink;

class Fields extends \common\models\fields\AqFields
{
    public function isUpdate()
    {
        if (!Yii::$app->user->can($this->getPermissionName('update')))
            return false;

        return true;
    }

    public function isGeneral()
    {
        if (!Yii::$app->user->can($this->getPermissionName('general')))
            return false;

        return true;
    }

    public function getGridViewColumn()
    {
        if ($this->type) {
            switch ($this->type->name) {
                case "date":
                    $result = $this->getDateColumn();
                    break;
                case "link":
                    $result = $this->getLinkColumn();
                    break;
                case "calculate":
                    $result = $this->getCalculateColumn();
                    break;
                case "password":
                    $result = $this->getPasswordColumn();
                    break;
                default:
                    $result = $this->getMainColumn();
                    break;
            }

            return $result;
        }
    }

    public function getEditGridViewColumn()
    {
        if ($this->type) {
            switch ($this->type->name) {
                case "date":
                    $result = $this->getEditDateColumn();
                    break;
                case "link":
                    $result = $this->getEditLinkColumn();
                    break;
                case "calculate":
                    $result = $this->getEditCalculateColumn();
                    break;
                case "password":
                    $result = $this->getEditPasswordColumn();
                    break;
                default:
                    $result = $this->getEditMainColumn();
                    break;
            }

            return $result;
        }
    }

    public function getCalculateColumn()
    {
        $name = $this->attributeCalculateName;
        return [
            'attribute' => $name,
            'value' => function($data) use ($name){
                $result = $data->{$name};

                if (is_numeric($result) && !is_int($result))
                    $result = number_format($result, 2, ",", "");

                return $result;
            },
            'pageSummary' => function($summary, $data, $widget) use ($name){
                if (!$this->page_summary)
                    return false;

                $sum = 0;
                foreach ($data as $value)
                {
                    $x = str_replace(",", ".", $value) * 1;
                    $sum += $x;
                }

                return str_replace(".", ",", $sum);
            }
        ];
    }

    public function getPasswordColumn()
    {
        $name = $this->attributePasswordName;
        return [
            'attribute' => $name,
            'value' => function($data) use ($name){
                return "";
            }
        ];
    }

    public function getMainColumn()
    {
        $name = $this->attributeName;
        return [
            'attribute' => $name,
            'value' => function($data) use ($name){
                $result = $data->{$name};

                if (is_numeric($result) && !is_int($result))
                    $result = number_format($result, 2, ",", "");

                return $result;
            },
            'pageSummary' => function($summary, $data, $widget) use ($name){
                if (!$this->page_summary)
                    return false;

                $sum = 0;
                foreach ($data as $value)
                {
                    $x = str_replace(",", ".", $value) * 1;
                    $sum += $x;
                }

                return str_replace(".", ",", $sum);
            }
        ];
    }

    public function getEditMainColumn()
    {
        $name = $this->attributeName;
        return [
            'attribute' => $name,
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table/editrecord', 'id_table_editrecord' => $this->table->id, 'id_field_editrecord' => $this->id]],
            ],
            'readonly' => ($this->isUpdate())?false:true
        ];
    }

    public function getEditCalculateColumn()
    {
        $name = $this->attributeCalculateName;
        return [
            'attribute' => $name,
            'value' => function($data) use ($name){
                $result = $data->{$name};

                if (is_numeric($result) && !is_int($result))
                    $result = number_format($result, 2, ",", "");

                return $result;
            },
            'readonly' => true
        ];
    }

    public function getEditPasswordColumn()
    {
        $name = $this->attributePasswordName;
        return [
            'attribute' => $name,
            'value' => function($data) use ($name){
                return "";
            },
            'readonly' => true
        ];
    }

    private function getEditDateColumn()
    {
        $name = $this->attributeName;
        $field = $this;
        return [
            'attribute' => $name,
            'class' => 'kartik\grid\EditableColumn',
            'readonly' => ($this->isUpdate())?false:true,
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table/editrecord', 'id_table_editrecord' => $this->table->id, 'id_field_editrecord' => $field->id]],
                'inputType' => Editable::INPUT_DATE
            ],
            'value' => function($data) use ($field){
                $format = $field->typeDate->format;
                return date($format, $data->{$field->name});
            },
        ];
    }

    private function getEditLinkColumn()
    {
        $dtArray = $this->typeLink->dataArray;
        $name = $this->attributeName;
        return [
            'attribute' => $name,
            'readonly' => ($this->isUpdate())?false:true,
            'class' => 'kartik\grid\EditableColumn',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table/editrecord', 'id_table_editrecord' => $this->table->id, 'id_field_editrecord' => $this->id]],
                'inputType' => Editable::INPUT_SELECT2,
                'options' => [
                    'data' => $dtArray
                ]
            ],
            'value' => function($data) use ($dtArray, $name){
                return ArrayHelper::getValue($dtArray, $data->$name);
            }
        ];
    }

    public function getDetailViewAttributes($model)
    {
        if ($this->type) {
            switch ($this->type->name) {
                case "date":
                    $result = $this->getDateAttribute($model);
                    break;
                case "link":
                    $result = $this->getLinkAttribute($model);
                    break;
                case "calculate":
                    $result = $this->getCalculateAttribute($model);
                    break;
                case "password":
                    $result = $this->getPasswordAttribute($model);
                    break;
                default:
                    $result = $this->getGeneralAttribute($model);
                    break;
            }

            return $result;
        }
    }

    private function getGeneralAttribute($model)
    {
        return [
            'attribute' => $this->attributeName,
            'displayOnly' => ($this->isUpdate())?false:true
        ];
    }

    private function getCalculateAttribute($model)
    {
        return [
            'attribute' => $this->attributeCalculateName,
            'displayOnly' => ($this->isUpdate())?false:true
        ];
    }

    private function getDateAttribute($model)
    {
        $name = $this->attributeName;
        return [
            'attribute' => $this->attributeName,
            'value' => date(ArrayHelper::getValue($this, "typeDate.format", "d.m.Y"), $model->$name),
            'displayOnly' => ($this->isUpdate())?false:true,
        ];
    }

    private function getPasswordAttribute($model)
    {
        $name = $this->attributePasswordName;
        return [
            'attribute' => $name,
            'value' => "",
            'displayOnly' => ($this->isUpdate())?false:true,
        ];
    }

    private function getLinkAttribute($model)
    {
        $id_field = $this->id;
        return [
            'attribute' => $this->attributeName,
            'value' => $model->getLink($id_field),
            'type' => DetailView::INPUT_SELECT2,
            'widgetOptions' => [
                'data' => $this->typeLink->dataArray
            ],
            'displayOnly' => ($this->isUpdate())?false:true
        ];
    }

    private function getDateColumn()
    {
        $name = $this->attributeName;
        return [
            'attribute' => $this->attributeName,
            'content' => function($data) use ($name){
                if ($this->typeDate)
                    $format = $this->typeDate->format;
                else
                    $format = "d.m.Y H:i:s";

                return date($format, $data->$name);
            }
        ];
    }

    private function getLinkColumn()
    {
        $id_field = $this->id;
        $name = $this->attributeName;
        return [
            'attribute' => $this->attributeName,
            'content' => function($data) use ($id_field){
                $result = $data->getLink($id_field);

                if (is_numeric($result) && !is_int($result))
                    $result = number_format($result, 2, ",", "");

                return $result;
            },
            'pageSummary' => function($summary, $data, $widget) use ($name){
                if (!$this->page_summary)
                    return false;

                $sum = 0;
                foreach ($data as $value)
                {
                    $x = str_replace(",", ".", $value) * 1;
                    $sum += $x;
                }

                return str_replace(".", ",", $sum);
            }
        ];
    }

    public function getRuleModel()
    {
        switch ($this->type->name)
        {
            case  "integer":
                $result = $this->getRuleInteger();
                break;
            case "text":
                $result = $this->getRuleText();
                break;
            case "date":
                $result = $this->getRuleDate();
                break;
            case "link":
                $result = $this->getRuleLink();
                break;
            case "calculate":
                $result = $this->getRuleCalculate();
                break;
            case "password":
                $result = $this->getRulePassword();
                break;
        }

        return $result;
    }

    public function getRuleInteger()
    {
        $result[] = [$this->attributeName, 'integer'];

        return $result;
    }

    public function getRulePassword()
    {
        $result[] = [$this->attributePasswordName, 'string'];

        return $result;
    }

    public function getRuleCalculate()
    {
        $result[] = [$this->attributeCalculateName, 'safe'];

        return $result;
    }

    public function getRuleText()
    {
        $result[] = [$this->attributeName, 'string'];

        return $result;
    }

    public function getRuleDate()
    {
        $result[] = [$this->attributeName, 'integer'];
        $result[] = [$this->attributeDateName, 'date', 'format' => 'php:'.ArrayHelper::getValue($this, "typeDate.format", "d.m.Y H:i:s")];

        return $result;
    }

    public function getRuleLink()
    {
        $result[] = [$this->attributeName, 'integer'];

        return $result;
    }

    public function getAttributeModel()
    {
        switch ($this->type->name)
        {
            case  "integer":
                $result = $this->getAttributeInteger();
                break;
            case "text":
                $result = $this->getAttributeText();
                break;
            case "date":
                $result = $this->getAttributeDate();
                break;
            case "link":
                $result = $this->getAttributeLink();
                break;
            case "calculate":
                $result = $this->getAttributeCalculate();
                break;
            case "password":
                $result = $this->getAttributePassword();
                break;
        }

        return $result;
    }

    public function getAttributeInteger()
    {
        $result[] = [$this->attributeName => $this->rus_name];

        return $result;
    }

    public function getAttributeText()
    {
        $result[] = [$this->attributeName => $this->rus_name];

        return $result;
    }

    public function getAttributePassword()
    {
        $result[] = [$this->attributePasswordName => $this->rus_name];

        return $result;
    }

    public function getAttributeDate()
    {
        $result[] = [$this->attributeName => $this->rus_name];
        $result[] = [$this->attributeDateName => $this->rus_name];

        return $result;
    }

    public function getAttributeLink()
    {
        $result[] = [$this->attributeName => $this->rus_name];

        return $result;
    }

    public function getAttributeCalculate()
    {
        $result[] = [$this->attributeCalculateName => $this->rus_name];

        return $result;
    }

    public function getAttributeNameMain()
    {
        switch ($this->type->name)
        {
            case  "integer":
                $result = $this->getAttributeName();
                break;
            case "text":
                $result = $this->getAttributeName();
                break;
            case "date":
                $result = $this->getAttributeDateName();
                break;
            case "link":
                $result = $this->getAttributeLinkName();
                break;
            case "calculate":
                $result = $this->getAttributeCalculateName();
                break;
            case "password":
                $result = $this->getAttributePasswordName();
                break;
        }

        return $result;
    }

    public function getAttributeName()
    {
        return $this->name."__".$this->id."__general";
    }

    public function getAttributeDateName()
    {
        return $this->name."__".$this->id."__dateText";
    }

    public function getAttributeCalculateName()
    {
        return $this->name."__".$this->id."__calculate";
    }

    public function getAttributePasswordName()
    {
        return $this->name."__".$this->id."__password";
    }


    public function getAttributeLinkName()
    {
        $parent_link = FieldLink::findOne(['id_field_visible' => $this->id]);

        $name = $this->name."__".$this->id."__link";

        if ($parent_link)
            $name = $parent_link->field->attributeLinkName.".".$name;

        return $name;
    }

    public function getAttrLinkName()
    {
        $parent_link = FieldLink::findOne(['id_field' => $this->id]);

        $name = $this->getAttributeNameMain();

        if ($parent_link)
            $name = $parent_link->fieldRef->table->name.".".$parent_link->fieldRef->attrLinkName;

        return $name;
    }

    public function getTypeLink()
    {
        return $this->hasOne(FieldLink::className(), ['id_field' => 'id']);
    }

    public function getScriptView()
    {
        return $this->hasOne(FieldScripts::className(), ['id_field' => 'id'])->where(['type' => 'view']);
    }

    public function getTypeDate()
    {
        return $this->hasOne(FieldDate::className(), ['id_field' => 'id']);
    }
}