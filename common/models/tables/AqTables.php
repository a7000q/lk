<?php

namespace common\models\tables;

use Yii;
use common\models\fields\AqFields;
use common\models\category\AqCategory;

/**
 * This is the model class for table "aq_tables".
 *
 * @property integer $id
 * @property string $name
 * @property string $rus_name
 * @property integer $sort
 *
 * @property AqFields[] $aqFields
 */
class AqTables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_tables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['sort', 'default', 'value' => 500],
            [['sort'], 'integer'],
            [['name', 'rus_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Физическое название',
            'rus_name' => 'Название',
            'sort' => 'Сортировка',
        ];
    }

    public function getFields()
    {
        return $this->hasMany(AqFields::className(), ['id_table' => 'id']);
    }

    public function getCategory()
    {
        return $this->hasOne(AqCategory::className(), ['id' => 'id_category']);
    }
}
