<?php

namespace frontend\models\table;

use frontend\models\fields\Fields;
use frontend\models\filters\Filter;
use frontend\models\tables\Tables;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use Yii;

class SearchModel extends Model
{
    public $id_table;
    private $fields;
    public $generalInput;

    public function getFieldFilters()
    {
        return Filter::find()->where(['id_table' => $this->id_table])->all();
    }

    public function getTable()
    {
        return Tables::findOne($this->id_table);
    }

    public function attributeLabels()
    {
        $table = $this->table;
        $result = array();
        foreach ($table->fields as $field)
        {
            $attributs = $field->getAttributeModel();
            foreach ($attributs as $attribut)
                $result = ArrayHelper::merge($result, $attribut);
        }

        return ArrayHelper::merge($result, [
            'generalInput' => 'Глобальный поиск'
        ]);
    }

    public function rules()
    {
        $result = array();
        $table = $this->table;
        foreach ($table->fields as $field)
        {
            $rules = $field->getRuleModel();
            foreach ($rules as $rule)
                $result[] = $rule;
        }

        return ArrayHelper::merge($result, [
            ['generalInput', 'safe']
        ]);
    }

    public function __get($name)
    {
        $param = explode("__", $name);

        if (isset($param[2]))
           return ArrayHelper::getValue($this->fields, $name);

        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        $param = explode("__", $name);

        if (isset($param[2]))
           $this->fields[$name] = $value;
        else
            return parent::__set($name, $value);
    }

    public function search($get)
    {
        $model = $this->getTableActive();
        $this->load($get);

        $query = $model::find()->filterLimitations(Yii::$app->user->id, $model::$tableBD->id);

        if ($this->fields) {
            foreach ($this->fields as $field_name => $value) {
                $where = $this->getWhere($field_name, $value);

                if ($where)
                    $query = $query->andWhere($where);
            }
        }

        if ($this->generalInput)
        {
            $fields = $model::$tableBD->fields;

            foreach ($fields as $field)
                $query = $query->addWhereGeneral($field, $this->generalInput);
        }

        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    private function getWhere($field_name, $value)
    {
        if (!$value)
            return false;

        $param = explode("__", $field_name);
        $field = Fields::findOne($param[1]);

        if (!$field)
            return false;

        if ($field->id_table != $this->id_table)
            return false;

        if ($field->name != $param[0])
            return false;

        if (!isset($param[2]))
            return false;

        switch ($param[2])
        {
            case "general":
                $result = $this->getGeneralWhere($param[0], $value);
                break;
            case "dateText":
                $result = $this->getDateWhere($param[0], $value);
                break;
        }

        return $result;
    }

    private function getTableActive()
    {
        $table = $this->table;

        $class = $table->getClassName();

        $model = new $class;
        $model::$tableBD = $table;

        return $model;
    }

    private function getGeneralWhere($field_name, $value)
    {
        return [$field_name => $value];
    }

    private function getDateWhere($field_name, $value)
    {
        $date = explode("-", $value);

        if (!isset($date[0]) or !isset($date[1]))
            return false;

        $dt1 = strtotime($date[0]." 00:00:00");
        $dt2 = strtotime($date[1]." 23:59:59");

        $result = "$field_name >= $dt1 AND $field_name <= $dt2";

        return $result;
    }
}