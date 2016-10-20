<?php

namespace frontend\models\table;

use backend\models\users\Limitations;
use common\models\limitations\AqLimitations;
use frontend\models\fields\Fields;
use Yii;
use frontend\models\tables\Tables;
use yii\helpers\ArrayHelper;
use frontend\models\fields\FieldLink;
use yii\db\ActiveQuery;

class TableActiveRecords extends \yii\db\ActiveRecord
{
    public static $tableBD;

    public function attributeLabels()
    {
        $result = array();
        foreach (static::$tableBD->fields as $field)
        {
            $attributs = $field->getAttributeModel();
            foreach ($attributs as $attribut)
                $result = ArrayHelper::merge($result, $attribut);
        }

        return $result;
    }

    public function rules()
    {
        $result = array();
        foreach (static::$tableBD->fields as $field)
        {
            $rules = $field->getRuleModel();
            foreach ($rules as $rule)
                $result[] = $rule;
        }

        return $result;
    }

    public function __get($name)
    {
        $param = explode("__", $name);

        if (isset($param[2]))
        {
            switch ($param[2])
            {
                case "general":
                    return $this->getGeneral($param[0], $param[1]);
                    break;
                case "dateText":
                    return $this->getDateText($param[0], $param[1]);
                    break;
                case "link":
                    return $this->getLinkFieldTable($param[1]);
                    break;
                default:
                    break;
            }
        }

        return parent::__get($name);
    }

    public function __call($name, $params)
    {
        $param = explode("__", $name);

        if (isset($param[2]))
        {
            switch ($param[2])
            {
                case "link":
                    return $this->getLinkFieldTable($param[1]);
                    break;
                default:
                    break;
            }
        }

        return parent::__call($name, $params);
    }

    public function __set($name, $value)
    {
        $param = explode("__", $name);

        if (isset($param[2]))
        {
            switch ($param[2])
            {
                case "general":
                    $this->setGeneral($param[0], $param[1], $value);
                    break;
                case "dateText":
                    $this->setDateText($param[0], $param[1], $value);
                    break;
                case "link":
                    $this->getLinkFieldTable($param[1]);
                    break;
                default:
                    break;
            }
        }
        else
            return parent::__set($name, $value);
    }

    private function getDateText($name, $id_field)
    {
        $field = Fields::findOne($id_field);
        $format = $field->typeDate->format;

        if ($this->$name == 0)
            return "";

        return date($format, $this->$name);
    }

    private function getGeneral($name, $id_field)
    {
        return $this->$name;
    }

    private function setDateText($name, $id_field, $value)
    {
        $this->$name = strtotime($value);
    }

    private function setGeneral($name, $id_field, $value)
    {
        $this->$name = $value;
    }

    public function getLink($id_field)
    {
        $link = FieldLink::findOne(['id_field' => $id_field]);

        if ($link)
        {
            $table = $link->fieldRef->table;

            $field_name = $link->field->name;
            $field_ref_name = $link->fieldRef->name;
            $field_visible_name = $link->fieldVisible->name;

            $class = $table->getClassName();

            $result = $this->hasOne($class, [$field_ref_name => $field_name])->one();

            if ($link->fieldVisible->type->name == "link")
                return $result->getLink($link->fieldVisible->id);

            return ArrayHelper::getValue($result, $field_visible_name);
        }
        else
            return false;

    }

    public function getLinkFieldTable($id_field)
    {
        $link = FieldLink::findOne(['id_field' => $id_field]);

        if ($link)
        {
            $table = $link->fieldRef->table;

            $field_name = $link->field->name;
            $field_ref_name = $link->fieldRef->name;
            $field_visible_name = $link->fieldVisible->name;

            $class = $table->getClassName();

            $result = $this->hasMany($class, [$field_ref_name => $field_name]);

            return $result;
        }
        else
            return false;
    }

    public static function find()
    {
        return new LimitationsQuery(get_called_class());
    }

}

class LimitationsQuery extends ActiveQuery
{
   public function filterLimitations($id_user, $id_table)
   {
       $limitations = AqLimitations::find()->joinWith('field')->where(['id_user' => $id_user])->andWhere(['id_table' => $id_table])->all();

       foreach ($limitations as $limitation)
       {
           $field_name = $limitation->field->name;
           $operand = $limitation->operand;
           $value = $limitation->value;

           $this->andWhere([$operand, $field_name, $value]);
       }

       return $this;
   }

    public function addWhereGeneral($field, $value)
    {
        $result = $this;
        switch ($field->type->name)
        {
           case "integer":
               $result = $this->addWhereInteger($field, $value);
               break;
           case "text":
               $result = $this->addWhereText($field, $value);
               break;
           case "link":
               $result = $this->addWhereLink($field, $value);
               break;
        }

       return $result;
    }

    private function addWhereInteger($field, $value)
    {
        $field_name = $field->table->name.".".$field->name;
        return $this->orWhere([$field_name => $value]);
    }

    private function addWhereText($field, $value)
    {
        $field_name = $field->table->name.".".$field->name;
        return $this->orWhere(['like', $field_name, $value]);
    }

    private function addWhereLink($field, $value)
    {
        $link = FieldLink::findOne(['id_field' => $field->id]);
        $field_name = $field->attributeLinkName;

        $result = $this->joinWith($field_name);
        $result = $result->addWhereGeneral($link->fieldVisible, $value);

        return $result;
    }


}
