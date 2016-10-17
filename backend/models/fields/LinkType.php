<?php

namespace backend\models\fields;


use backend\models\tables\Tables;
use common\models\fields\AqFieldLink;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class LinkType extends Model
{
    public $id_table;
    public $id_field;
    public $id_field_ref;
    public $id_field_visible;

    public function rules()
    {
        return [
            [['id_table', 'id_field_ref', 'id_field_visible'], 'integer'],
            [['id_table', 'id_field_ref', 'id_field_visible'], 'required', 'isEmpty' => function ($value) {
                return empty($value);
            }]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_table' => 'Таблица',
            'id_field_ref' => 'Связующее поле',
            'id_field_visible' => 'Отображаемое поле'
        ];
    }

    public function getFieldsArray()
    {
        if (!$this->id_table)
            return [];

        $table = Tables::findOne($this->id_table);

        return ArrayHelper::map($table->fields, 'id', 'rus_name');
    }

    public function save()
    {
        if (!$this->validate())
            return false;

        $link = AqFieldLink::findOne(['id_field' => $this->id_field]);

        if (!$link)
            $link = new AqFieldLink();

        $link->id_field = $this->id_field;
        $link->id_field_ref = $this->id_field_ref;
        $link->id_field_visible = $this->id_field_visible;

        if (!$link->validate())
            return false;

        $link->save();
        return true;
    }

    public function loadFieldLink()
    {
        if (!$this->id_field)
            return false;

        $link = AqFieldLink::findOne(['id_field' => $this->id_field]);

        $this->id_field_ref = $link->id_field_ref;
        $this->id_field_visible = $link->id_field_visible;

        $this->id_table = $link->fieldRef->id_table;
    }

}