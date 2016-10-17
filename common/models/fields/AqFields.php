<?php

namespace common\models\fields;

use common\models\limitations\AqLimitations;
use Yii;
use common\models\tables\AqTables;


class AqFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sort', 'default', 'value' => 500],
            [['id_table', 'sort', 'id_type'], 'integer'],
            [['name', 'rus_name'], 'string', 'max' => 255],
            [['id_table'], 'exist', 'skipOnError' => true, 'targetClass' => AqTables::className(), 'targetAttribute' => ['id_table' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_table' => 'Id Table',
            'name' => 'Физическое название',
            'rus_name' => 'Название',
            'sort' => 'Сортировка',
            'id_type' => 'Тип'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(AqTables::className(), ['id' => 'id_table']);
    }

    public function getPermissionName($name)
    {
        return $name.'-field-'.$this->id;
    }

    public function getType()
    {
        return $this->hasOne(AqFieldType::className(), ['id' => 'id_type']);
    }

    public function  getTypeDate()
    {
        return $this->hasOne(AqFieldDate::className(), ['id_field' => 'id']);
    }

    public function getTypeLink()
    {
        return $this->hasOne(AqFieldLink::className(), ['id_field' => 'id']);
    }

    public function getAqLimitations()
    {
        return $this->hasMany(AqLimitations::className(), ['id_field' => 'id']);
    }
}
