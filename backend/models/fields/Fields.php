<?php

namespace backend\models\fields;

use Yii;

class Fields extends \common\models\fields\AqFields
{
    static public function newField($id_table)
    {
        $model = new Fields();
        $model->id_table = $id_table;
        $model->save();
    }
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
            $this->addStandartPermissions();

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $this->deleteAllPermission();
        return parent::beforeDelete();
    }

    private function addStandartPermissions()
    {
        $this->addGeneralPermission();
        $this->addPermission('update');
    }

    private function addGeneralPermission()
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName('general');

        $permission = $auth->getPermission($permission_name);

        if ($permission == null)
        {
            $permission = $auth->createPermission($permission_name);
            $auth->add($permission);
        }
    }


    private function addPermission($name)
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName($name);

        $general_permission = $auth->getPermission($this->getPermissionName('general'));
        $permission = $auth->getPermission($permission_name);

        if ($permission == null && $general_permission)
        {
            $permission = $auth->createPermission($permission_name);
            $auth->add($permission);

            $auth->addChild($general_permission, $permission);
        }
    }

    private function removePermission($name)
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName($name);

        $permission = $auth->getPermission($permission_name);
        $childrens = $auth->getChildren($permission_name);


        if ($permission != null)
        {
            foreach ($childrens as $children)
                $auth->remove($children);

            $auth->remove($permission);
        }
    }

    private function deleteAllPermission()
    {
        $this->removePermission('general');
    }

    public function getPermissionName($name)
    {
        return $name.'-field-'.$this->id;
    }

}