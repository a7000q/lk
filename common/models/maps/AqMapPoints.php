<?php

namespace common\models\maps;

use Yii;

/**
 * This is the model class for table "aq_map_points".
 *
 * @property integer $id
 * @property integer $id_map
 * @property string $name
 * @property string $description
 * @property string $value
 *
 * @property AqMaps $idMap
 */
class AqMapPoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_map_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_map'], 'integer'],
            [['name', 'description', 'value'], 'string', 'max' => 255],
            [['id_map'], 'exist', 'skipOnError' => true, 'targetClass' => AqMaps::className(), 'targetAttribute' => ['id_map' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_map' => 'Id Map',
            'name' => 'Название',
            'description' => 'Описание',
            'value' => 'Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMap()
    {
        return $this->hasOne(AqMaps::className(), ['id' => 'id_map']);
    }

    public function getPermissionName($name)
    {
        return $name.'-map-point-'.$this->id;
    }
}
