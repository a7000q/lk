<?php

namespace common\models\tables\sort;

use Yii;
use common\models\tables\AqTables;
use common\models\fields\AqFields;
/**
 * This is the model class for table "aq_tables_sort".
 *
 * @property integer $id
 * @property integer $id_table
 * @property integer $id_field
 * @property integer $sort
 * @property integer $action
 *
 * @property AqFields $idField
 * @property AqTables $idTable
 */
class AqTablesSort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_tables_sort';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_table', 'id_field', 'sort', 'action'], 'integer'],
            [['id_field'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field' => 'id']],
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
            'id_field' => 'Поле',
            'sort' => 'Сортировка',
            'action' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AqFields::className(), ['id' => 'id_field']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(AqTables::className(), ['id' => 'id_table']);
    }
}
