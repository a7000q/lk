<?php

namespace common\models\pages;

use Yii;
use common\models\category\AqCategory;

/**
 * This is the model class for table "aq_pages".
 *
 * @property integer $id
 * @property integer $id_category
 * @property string $name
 * @property string $rus_name
 * @property integer $sort
 *
 * @property AqCategory $idCategory
 */
class AqPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_category', 'sort'], 'integer'],
            [['name', 'rus_name'], 'string', 'max' => 255],
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
            'rus_name' => 'Название (Рус)',
            'sort' => 'Сортировка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategory()
    {
        return $this->hasOne(AqCategory::className(), ['id' => 'id_category']);
    }
}
