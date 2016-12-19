<?php

namespace common\models\maps;

use Yii;
use common\models\category\AqCategory;

/**
 * This is the model class for table "aq_maps".
 *
 * @property integer $id
 * @property integer $id_category
 * @property string $name
 *
 * @property AqMapPoints[] $aqMapPoints
 * @property AqCategory $idCategory
 */
class AqMaps extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_maps';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['id_category'], 'exist', 'skipOnError' => true, 'targetClass' => AqCategory::className(), 'targetAttribute' => ['id_category' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_category' => 'Id Category',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMapPoints()
    {
        return $this->hasMany(AqMapPoints::className(), ['id_map' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(AqCategory::className(), ['id' => 'id_category']);
    }

    public function getPermissionName($name)
    {
        return $name.'-map-'.$this->id;
    }
}
