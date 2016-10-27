<?php

namespace common\models\tables;

use Yii;
use common\models\fields\AqFields;

/**
 * This is the model class for table "aq_table_link".
 *
 * @property integer $id
 * @property integer $id_table
 * @property integer $id_field
 * @property integer $id_table_ref
 * @property integer $id_field_ref
 *
 * @property AqFields $idField
 * @property AqFields $idFieldRef
 * @property AqTables $idTable
 * @property AqTables $idTableRef
 */
class AqTableLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_table_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_table', 'id_field', 'id_table_ref', 'id_field_ref'], 'integer'],
            [['id_field'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field' => 'id']],
            [['id_field_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field_ref' => 'id']],
            [['id_table'], 'exist', 'skipOnError' => true, 'targetClass' => AqTables::className(), 'targetAttribute' => ['id_table' => 'id']],
            [['id_table_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AqTables::className(), 'targetAttribute' => ['id_table_ref' => 'id']],
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
            'id_table_ref' => 'Связанная таблица',
            'id_field_ref' => 'Связующее поле',
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
    public function getFieldRef()
    {
        return $this->hasOne(AqFields::className(), ['id' => 'id_field_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTable()
    {
        return $this->hasOne(AqTables::className(), ['id' => 'id_table']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTableRef()
    {
        return $this->hasOne(AqTables::className(), ['id' => 'id_table_ref']);
    }
}
