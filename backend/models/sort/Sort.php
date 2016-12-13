<?php


namespace backend\models\sort;


use common\models\tables\sort\AqTablesSort;

class Sort extends AqTablesSort
{
    static public function newSort($id_table)
    {
        $sort = new Sort(['id_table' => $id_table]);
        $sort->save();
    }
}