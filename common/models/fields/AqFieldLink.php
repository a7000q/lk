<?php

namespace common\models\fields;

use Yii;

/**
 * This is the model class for table "aq_field_link".
 *
 * @property integer $id
 * @property integer $id_field
 * @property integer $id_field_ref
 * @property integer $id_field_visible
 *
 * @property AqFields $idField
 * @property AqFields $idFieldRef
 * @property AqFields $idFieldVisible
 */
class AqFieldLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_field_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_field', 'id_field_ref', 'id_field_visible'], 'integer'],
            ['id_field', 'unique'],
            [['id_field'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field' => 'id']],
            [['id_field_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field_ref' => 'id']],
            [['id_field_visible'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field_visible' => 'id']],
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
            'id_field_ref' => 'Id Field Ref',
            'id_field_visible' => 'Id Field Visible',
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
    public function getFieldVisible()
    {
        return $this->hasOne(AqFields::className(), ['id' => 'id_field_visible']);
    }
}
