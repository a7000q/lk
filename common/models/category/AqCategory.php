<?php

namespace common\models\category;

use Yii;
use common\models\tables\AqTables;

class AqCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['sort', 'default', 'value' => 500],
            [['sort'], 'integer'],
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
            'name' => 'Название',
            'sort' => 'Сортировка',
        ];
    }

    public function getTables()
    {
        return $this->hasMany(AqTables::className(), ['id_category' => 'id']);
    }
}
