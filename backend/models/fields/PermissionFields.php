<?php

namespace backend\models\fields;

use Yii;
use serhatozles\arraysearch\ArraySearch;
use yii\helpers\ArrayHelper;

class PermissionFields extends Fields
{
    public $role_name;

    public function rules()
    {
        return ArrayHelper::merge([
            [['general', 'update'], 'string'],
            ['role_name', 'string']
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'general' => 'Доступность',
            'update' => 'Редактирование'
        ], parent::attributeLabels());
    }

    public function isPermissionByRole($permission_name)
    {
        $auth = Yii::$app->authManager;
        $permissions = $auth->getPermissionsByRole($this->role_name);

        $permission_name = $this->getPermissionName($permission_name);

        $query = "name='".$permission_name."'";
        $result = ArraySearch::q($permissions, $query);

        if ($result)
            return true;

        return false;
    }

    public function installPermission($permission_name)
    {
        $auth = Yii::$app->authManager;

        $parent = $auth->getRole($this->role_name);

        $permission_name = $this->getPermissionName($permission_name);
        $permission = $auth->getPermission($permission_name);

        $auth->addChild($parent, $permission);
    }

    public function reInstallPermission($permission_name)
    {
        $auth = Yii::$app->authManager;

        $parent = $auth->getRole($this->role_name);

        $permission_name = $this->getPermissionName($permission_name);
        $permission = $auth->getPermission($permission_name);

        $auth->removeChild($parent, $permission);
    }

    public function getGeneral()
    {
        return $this->isPermissionByRole('general');
    }

    public function setGeneral($value)
    {
        if ($value)
            $this->installPermission('general');
        else
            $this->reInstallPermission('general');
    }

    public function getUpdate()
    {
        return $this->isPermissionByRole('update');
    }

    public function setUpdate($value)
    {
        if ($value)
            $this->installPermission('update');
        else
            $this->reInstallPermission('update');
    }
}