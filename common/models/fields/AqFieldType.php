<?php

namespace common\models\fields;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "aq_field_type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AqFields[] $aqFields
 */
class AqFieldType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_field_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAqFields()
    {
        return $this->hasMany(AqFields::className(), ['id_type' => 'id'])->inverseOf('idType');
    }

    static public function getAllArray()
    {
        return ArrayHelper::map(static::find()->all(), 'id', 'name');
    }
}
