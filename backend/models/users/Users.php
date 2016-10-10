<?php

namespace backend\models\users;

use common\models\User;
use backend\models\roles\Role;
use yii\data\ArrayDataProvider;

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
}