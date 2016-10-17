<?php

namespace common\models\limitations;

use Yii;
use common\models\fields\AqFields;
use common\models\User;

/**
 * This is the model class for table "aq_limitations".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_field
 * @property string $operand
 * @property string $value
 *
 * @property AqFields $idField
 * @property User $idUser
 */
class AqLimitations extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'aq_limitations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_field'], 'integer'],
            [['operand', 'value'], 'string'],
            [['id_field'], 'exist', 'skipOnError' => true, 'targetClass' => AqFields::className(), 'targetAttribute' => ['id_field' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_field' => 'Id Field',
            'operand' => 'Operand',
            'value' => 'Value',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
