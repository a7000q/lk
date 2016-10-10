<?php

namespace frontend\models\table;

use Yii;
use frontend\models\tables\Tables;
use yii\helpers\ArrayHelper;

class TableActiveRecords extends \yii\db\ActiveRecord
{
    public static $table_name;
    public static $tableBD;

    public static function tableName()
    {
        return static::$table_name;
    }

    static public function getTable($id)
    {
        $table = Tables::findOne($id);

        if (!$table)
            return false;

        static::$tableBD  = $table;
        static::$table_name = $table->name;

        return static::class;
    }

    public function attributeLabels()
    {
        $fields = ArrayHelper::map(static::$tableBD->fields, 'name', 'rus_name');
        return $fields;
    }
}
