<?php

namespace backend\models\filters;


use common\models\filters\AqFilters;
use Yii;

class Filters extends AqFilters
{
    static public function newFilter($id)
    {
        $filter = new Filters();

        $filter->id_table = $id;
        $filter->save();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
            $this->addStandartPermissions();

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $this->deleteAllStandartPermission();

        return parent::beforeDelete();
    }

    private function addStandartPermissions()
    {
        $this->addPermission('general');
    }

    private function addPermission($name)
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName($name);

        $permission = $auth->getPermission($permission_name);

        if ($permission == null)
        {
            $permission = $auth->createPermission($permission_name);
            $auth->add($permission);
        }
    }

    private function deleteAllStandartPermission()
    {
        $this->removePermission('general');
    }

    private function removePermission($name)
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName($name);

        $permission = $auth->getPermission($permission_name);

        if ($permission != null)
            $auth->remove($permission);
    }
}