<?php

namespace common\models\filters;

use Yii;
use common\models\fields\AqFields;

/**
 * This is the model class for table "aq_filters".
 *
 * @property integer $id
 * @property integer $id_field
 * @property string $value
 *
 * @property AqFields $idField
 */
class AqFilters extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_filters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_field', 'id_table'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['id_field'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field' => 'id']],
            [['id_field'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_field' => 'Поле',
            'value' => 'Значение по умолчанию',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AqFields::className(), ['id' => 'id_field']);
    }

    public function getPermissionName($name)
    {
        return $name.'-filter-'.$this->id;
    }
}
