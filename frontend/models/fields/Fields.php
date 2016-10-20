<?php


namespace frontend\models\fields;

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
                default:
                    $result = $this->attributeName;
                    break;
            }

            return $result;
        }
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
                return date($this->typeDate->format, $data->$name);
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
        }

        return $result;
    }

    public function getRuleInteger()
    {
        $result[] = [$this->attributeName, 'integer'];

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
        $result[] = [$this->attributeDateName, 'date', 'format' => 'php:'.$this->typeDate->format];

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

    public function getAttributeName()
    {
        return $this->name."__".$this->id."__general";
    }

    public function getAttributeDateName()
    {
        return $this->name."__".$this->id."__dateText";
    }

    public function getTypeLink()
    {
        return $this->hasOne(FieldLink::className(), ['id_field' => 'id']);
    }
}