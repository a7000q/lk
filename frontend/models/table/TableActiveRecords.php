<?php

namespace frontend\models\table;

use frontend\models\limitations\Limitations;
use frontend\models\fields\Fields;
use frontend\models\tables\TableLink;
use Yii;
use frontend\models\tables\Tables;
use yii\helpers\ArrayHelper;
use frontend\models\fields\FieldLink;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\data\ActiveDataProvider;

class TableActiveRecords extends \yii\db\ActiveRecord
{
    static $tableBD;

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

    private function getFieldScript($name)
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
                    return $this->getLink($param[1]);
                    break;
                case "calculate":
                    return $this->getCalculateField($param[1]);
                    break;
                default:
                    break;
            }
        }
    }

    public function __get($name)
    {
        $field = Fields::find()->where(['=', 'rus_name', $name])->andWhere(['<>', 'rus_name', 'id'])->andWhere(['id_table' => $this::$tableBD->id])->one();

        if ($field)
            return $this->getFieldScript($field->attributeNameMain);

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
                case "calculate":
                    return $this->getCalculateField($param[1]);
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

    private function getCalculateField($id_field)
    {
        $field = Fields::findOne($id_field);

        $script = ArrayHelper::getValue($field, "scriptView.code");
        return eval($script);
    }

    private function getDateText($name, $id_field)
    {
        $field = Fields::findOne($id_field);
        $format = ArrayHelper::getValue($field, "typeDate.format", "d.m.Y");

        if ($this->$name == 0)
            return "";

        return date($format, $this->$name);
    }

    private function getGeneral($name, $id_field)
    {
        $result = $this->$name;

        return $result;
    }

    private function setDateText($name, $id_field, $value)
    {
        $this->$name = strtotime($value);
    }

    private function setGeneral($name, $id_field, $value)
    {
        $this->$name = $value;
    }

    public function addLinkRecord($id_link, $id)
    {
        $link = TableLink::findOne($id_link);

        $class = $link->tableRef->getClassName();
        $record = new $class;
        $record::$tableBD = $link->tableRef;

        $field_link = $link->fieldRef->name;

        $record->{$field_link} = $id;
        $record->save();
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
            $class::$tableBD = $table;

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
            $class::$tableBD = $table;

            $result = $this->hasMany($class, [$field_ref_name => $field_name]);

            return $result;
        }
        else
            return false;
    }

    public function getLinkTableLink($link)
    {
        $class = $link->tableRef->getClassName();

        $class::$tableBD = $link->tableRef;

        $field_name = $link->fieldRef->name;

        $result = $this->hasMany($class::className(), [$field_name => $link->field->attributeNameMain]);

        return $result;
    }

    public function getLinkTableLinkDataProvider($link)
    {
        return new ActiveDataProvider([
            'query' => $this->getLinkTableLink($link)
        ]);
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
       $limitations = Limitations::find()->joinWith('field')->where(['id_user' => $id_user])->andWhere(['id_table' => $id_table])->all();

       foreach ($limitations as $limitation)
       {
           $field = $limitation->field;
           $field_name = $this->getLName($field);
           $operand = $limitation->operand;
           $value = $limitation->value;
           $r_where[$field_name][] = ['operand' => $operand, 'value' => $value];
       }

       if (isset($r_where))
       {
           foreach ($r_where as $field_name => $where)
           {
               $f_where = array();
               foreach ($where as $wh)
               {
                   $f_where[] = [$wh["operand"], $field_name, $wh["value"]];
               }

               $f_where = ArrayHelper::merge(['or'], $f_where);

               $this->andWhere($f_where);
           }
       }

       return $this;
   }

    public function addWhereGeneral($field, $value)
    {
        $result = false;
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
        if (!is_int($value))
            return false;

        $field_name = $field->table->name.".".$field->name;
        $result = ["$field_name = $value"];
        return $result;
    }

    private function addWhereText($field, $value)
    {
        $field_name = $field->table->name.".".$field->name;
        $result = ["$field_name like '%$value%'"];
        return $result;
    }

    private function addWhereLink($field, $value)
    {
        $link = FieldLink::findOne(['id_field' => $field->id]);
        $field_name = $field->attributeLinkName;

        $result = $this->innerJoinWith($field_name);
        $result = $result->addWhereGeneral($link->fieldVisible, $value);

        return $result;
    }

    private function getLName($field, $id_link = false)
    {
        if ($field->type->name != "link") {
            if ($id_link == false)
                return $field->table->name.".".$field->name;

            $link = FieldLink::findOne($id_link);
            return $link->field->table->name . "." . $link->field->name;
        }

        $this->innerJoinWith($field->attributeLinkName);

        $id_link = $field->typeLink->id;
        return $this->getLName($field->typeLink->fieldVisible, $id_link);
    }


}
