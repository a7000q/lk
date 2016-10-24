<?php

namespace common\models\fields;

use Yii;

/**
 * This is the model class for table "aq_field_scripts".
 *
 * @property integer $id
 * @property integer $id_field
 * @property string $type
 * @property string $code
 *
 * @property AqFields $idField
 */
class AqFieldScripts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_field_scripts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_field'], 'integer'],
            [['type', 'code'], 'string'],
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
            'type' => 'Type',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdField()
    {
        return $this->hasOne(AqFields::className(), ['id' => 'id_field'])->inverseOf('aqFieldScripts');
    }
}
