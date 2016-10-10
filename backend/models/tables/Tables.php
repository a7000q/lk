<?php

namespace backend\models\tables;

use yii\data\ActiveDataProvider;
use backend\models\fields\Fields;
use yii;


class Tables extends \common\models\tables\AqTables
{
    public function getFieldsDataProvider()
    {
        return new ActiveDataProvider(
            [
                'query' => Fields::find()->where(['id_table' => $this->id])
            ]
        );
    }

    static public function newTable($id_category)
    {
        $model = new Tables();
        $model->id_category = $id_category;
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
        $this->addPermission('view');
        $this->addPermission('create');
        $this->addPermission('update');
        $this->addPermission('delete');
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
        $this->removePermission('view');
        $this->removePermission('create');
        $this->removePermission('update');
        $this->removePermission('delete');
    }
}