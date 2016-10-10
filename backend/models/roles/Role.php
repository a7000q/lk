<?php

namespace backend\models\roles;

use yii\base\Model;
use Yii;
use serhatozles\arraysearch\ArraySearch;

class Role extends Model
{
    public static function getAll()
    {
        $auth = Yii::$app->authManager;
        $result = $auth->getRoles();

        return $result;
    }

    static public function getRolesByUser($id_user)
    {
        $auth = Yii::$app->authManager;
        $result = $auth->getRolesByUser($id_user);

        return $result;
    }

    static public function addRoleByUser($role_name, $id_user)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role_name);

        if (!$auth->getAssignment($role_name, $id_user))
            $auth->assign($role, $id_user);
    }

    static public function removeRoleByUser($role_name, $id_user)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($role_name);

        if ($auth->getAssignment($role_name, $id_user))
            $auth->revoke($role, $id_user);
    }
}