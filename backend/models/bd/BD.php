<?php

namespace backend\models\bd;

use yii\helpers\ArrayHelper;
use yii;
use backend\models\buttons\ButtonsType;

class BD extends \yii\base\Model
{
    static public function getArrayTables()
    {
        $db = Yii::$app->getDb();
        $result = $db->createCommand('SHOW TABLES')->queryAll();

        $r = array();
        foreach ($result as $value)
        {
            $v = current($value);
            if ((strpos($v, 'aq_') === 0) or ($v == 'user') or ($v == 'migration'))
                continue;

            $r[$v] = $v;
        }

        return $r;
    }

    static public function getArrayFields($table)
    {
        $db = Yii::$app->getDb();
        $result = $db->createCommand('SHOW COLUMNS FROM '.$table)->queryAll();

        $r = array();
        foreach ($result as $value)
        {
            $v = current($value);
            $r[$v] = $v;
        }

        return $r;
    }

    static public function getButtonsTypes()
    {
        $buttons = ButtonsType::find()->all();
        $result = ArrayHelper::map($buttons, "name", "name");

        return $result;
    }
}