<?php


namespace frontend\models\fields;

use backend\models\fields\FieldScripts;
use kartik\detail\DetailView;
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
                default:
                    $result = $this->getMainColumn();
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
            'pageSummary' => $this->page_summary?true:false
        ];
    }

    public function getMainColumn()
    {
        $name = $this->attributeName;
        return [
            'attribute' => $name,
            'pageSummary' => $this->page_summary?true:false
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
            'value' => date($this->typeDate->format, $model->$name),
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
        return [
            'attribute' => $this->attributeName,
            'content' => function($data) use ($id_field){
                return $data->getLink($id_field);
            },
            'pageSummary' => $this->page_summary?true:false
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
        }

        return $result;
    }

    public function getRuleInteger()
    {
        $result[] = [$this->attributeName, 'integer'];

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

    public function getAttributeLinkName()
    {
        $parent_link = FieldLink::findOne(['id_field_visible' => $this->id]);

        $name = $this->name."__".$this->id."__link";

        if ($parent_link)
            $name = $parent_link->field->attributeLinkName.".".$name;

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


}