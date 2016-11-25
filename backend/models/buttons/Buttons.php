<?php

namespace backend\models\buttons;


use backend\models\tables\Tables;
use common\models\buttons\AqButtons;

class Buttons extends AqButtons
{
    public static function newButton($id_table)
    {
        $button = new Buttons([
            'id_table' => $id_table
        ]);

        $button->save();
    }

    public function getTable()
    {
        return $this->hasOne(Tables::className(), ['id' => 'id_table']);
    }

}