<?php

namespace common\models\fields;

use Yii;
use common\models\tables\AqTables;

/**
 * This is the model class for table "aq_fields".
 *
 * @property integer $id
 * @property integer $id_table
 * @property string $name
 * @property string $rus_name
 * @property integer $sort
 *
 * @property AqTables $idTable
 */
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
            [['id_table', 'sort'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(AqTables::className(), ['id' => 'id_table']);
    }
}
