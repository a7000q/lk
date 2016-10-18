<?php

namespace backend\models\users;


use backend\models\fields\Fields;
use backend\models\tables\Tables;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use Yii;

class AddLimitation extends Model
{
    public $id_table;
    public $id_user;
    public $id_field;
    public $operand;
    public $value;

    public function attributeLabels()
    {
        return [
            'id_table' => 'Выберите таблицу',
            'id_field' => 'Выберите поле',
            'operand' => 'Выберите операцию сравнения',
            'value' => 'Значения'
        ];
    }

    public function rules()
    {
        return [
            [['id_table', 'id_user', 'id_field'], 'integer'],
            [['operand', 'value'], 'string']
        ];
    }

    public function getTablesArray()
    {
        $tables = Tables::find()->all();
        $auth = Yii::$app->authManager;
        $result = ArrayHelper::getColumn($tables, function($table) use ($auth){
                return ['name' => $table->rus_name, 'id' => $table->id];
        });

        $result = ArrayHelper::map($result, 'id', 'name');

        $result = array_filter($result);
        $result = ArrayHelper::merge(['Выберите таблицу'], $result);

        return $result;
    }

    public function getFieldsArray()
    {
        $fields = Fields::find()->where(['id_table' => $this->id_table])->all();
        $auth = Yii::$app->authManager;

        $result = ArrayHelper::getColumn($fields, function($field) use ($auth){
            return ['name' => $field->rus_name, 'id' => $field->id];
        });

        $result = ArrayHelper::map($result, 'id', 'name');

        $result = array_filter($result);
        $result = ArrayHelper::merge(['Выберите поле'], $result);

        return $result;
    }

    public function getOperandsArray()
    {
        switch ($this->field->type->name)
        {
            case "integer":
                $result = [
                    '=' => '=',
                    '>=' => '>=',
                    '<=' => '<=',
                    '!=' => '!='
                ];
                break;
            case "text":
                $result = [
                    '=' => '=',
                    'like' => 'like',
                    '!=' => '!='
                ];
                break;
            case "date":
                $result = [
                    '=' => '=',
                    '>=' => '>=',
                    '<=' => '<='
                ];
                break;
            case "link":
                $result = [
                    '=' => '=',
                    '!=' => '!='
                ];
                break;
        }

        return $result;
    }

    public function getField()
    {
        return Fields::findOne($this->id_field);
    }

    public function save()
    {
        $model = new Limitations();
        $model->id_user = $this->id_user;
        $model->id_field = $this->id_field;
        $model->operand = $this->operand;

        $model->value = $this->getValueField();

        $model->save();
    }

    private function getValueField()
    {
        switch ($this->field->type->name)
        {
            case "integer":
                $result = (string)$this->value;
                break;
            case "text":
                $result = (string)$this->value;
                break;
            case "date":
                $result = (string)strtotime($this->value);
                break;
            case "link":
                $result = (string)$this->value;
                break;
        }

        return $result;
    }
}