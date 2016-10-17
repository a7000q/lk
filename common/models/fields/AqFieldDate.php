<?php

namespace common\models\fields;

use Yii;

/**
 * This is the model class for table "aq_field_date".
 *
 * @property integer $id
 * @property integer $id_field
 * @property string $format
 *
 * @property AqFields $idField
 */
class AqFieldDate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_field_date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_field'], 'integer'],
            [['format'], 'string', 'max' => 255],
            [['id_field'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_field' => 'Id Field',
            'format' => 'Format',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getField()
    {
        return $this->hasOne(AqFields::className(), ['id' => 'id_field'])->inverseOf('aqFieldDates');
    }
}
