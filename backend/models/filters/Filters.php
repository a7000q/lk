<?php

namespace backend\models\filters;


use common\models\filters\AqFilters;

class Filters extends AqFilters
{
    static public function newFilter($id)
    {
        $filter = new Filters();

        $filter->id_table = $id;
        $filter->save();
    }
}