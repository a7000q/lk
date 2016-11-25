<?php

namespace common\models\buttons;

use Yii;
use common\models\tables\AqTables;

/**
 * This is the model class for table "aq_buttons".
 *
 * @property integer $id
 * @property integer $id_table
 * @property string $name
 * @property string $type
 *
 * @property AqTables $idTable
 */
class AqButtons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_buttons';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_table'], 'integer'],
            [['name', 'type'], 'string', 'max' => 255],
            [['id_table'], 'exist', 'skipOnError' => true, 'targetClass' => AqTables::className(), 'targetAttribute' => ['id_table' => 'id']],
            ['code', 'string']
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
            'name' => 'Название',
            'type' => 'Тип',
            'code' => 'PHP код'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTable()
    {
        return $this->hasOne(AqTables::className(), ['id' => 'id_table']);
    }
}
