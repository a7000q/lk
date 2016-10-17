<?php

namespace backend\models\users;

use common\models\User;
use backend\models\roles\Role;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;

class Users extends User
{
    public function getRoles()
    {
        return Role::getRolesByUser($this->id);
    }

    public function getRolesDataProvider()
    {
        return new ArrayDataProvider(['allModels' => $this->roles]);
    }

    public function getLimitations()
    {
        return $this->hasMany(Limitations::className(), ['id_user' => 'id']);
    }

    public function getLimitationsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => $this->getLimitations()
        ]);
    }
}