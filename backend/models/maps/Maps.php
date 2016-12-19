<?php

namespace backend\models\maps;


use common\models\maps\AqMaps;
use yii\data\ActiveDataProvider;
use Yii;

class Maps extends AqMaps
{
    static public function newMap($id_category)
    {
        $map = new Maps([
            'id_category' => $id_category
        ]);

        $map->save();
    }

    public function getPointsDataProvider()
    {
        return new ActiveDataProvider([
            'query' => MapPoints::find()->where(['id_map' => $this->id])
        ]);
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