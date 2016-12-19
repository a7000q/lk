<?php

namespace backend\models\maps;


use common\models\maps\AqMapPoints;
use Yii;

class MapPoints extends AqMapPoints
{
    static public function newPoint($id_map)
    {
        $point = new MapPoints([
           'id_map' => $id_map
        ]);

        $point->save();
    }

    public function getMap()
    {
        return $this->hasOne(Maps::className(), ['id' => 'id_map']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
            $this->addStandartPermissions();

        parent::afterSave($insert, $changedAttributes);
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
    }

    public function beforeDelete()
    {
        $this->deleteAllStandartPermission();

        return parent::beforeDelete();
    }
}