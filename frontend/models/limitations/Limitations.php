<?php

namespace frontend\models\limitations;


use common\models\limitations\AqLimitations;
use frontend\models\fields\Fields;

class Limitations extends AqLimitations
{
    public function getField()
    {
        return $this->hasOne(Fields::className(), ['id' => 'id_field']);
    }

}