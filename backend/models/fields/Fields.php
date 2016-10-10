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
        $this->deleteAllStandartPermission();
        return parent::beforeDelete();
    }

    private function addStandartPermissions()
    {
        $this->addPermission('general');
        $this->addPermission('update');
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

    private function removePermission($name)
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName($name);

        $permission = $auth->getPermission($permission_name);

        if ($permission != null)
            $auth->remove($permission);
    }

    private function deleteAllStandartPermission()
    {
        $this->removePermission('general');
        $this->removePermission('update');
    }

}