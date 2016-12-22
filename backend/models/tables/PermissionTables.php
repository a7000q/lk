<?php

namespace backend\models\tables;

use backend\models\filters\PermissionFilters;
use yii;
use serhatozles\arraysearch\ArraySearch;
use yii\helpers\ArrayHelper;
use backend\models\fields\PermissionFields;

class PermissionTables extends Tables
{
    public $role_name;

    public function rules()
    {
        return ArrayHelper::merge([
            [['general', 'view', 'create', 'update', 'delete'], 'string'],
            ['role_name', 'string']
        ], parent::rules());
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge([
            'general' => 'Доступность',
            'view' => 'Просмотр',
            'create' => 'Создание',
            'update' => 'Редактирование',
            'delete' => 'Удаление',
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

    public function getView()
    {
        return $this->isPermissionByRole('view');
    }

    public function setView($value)
    {
        if ($value)
            $this->installPermission('view');
        else
            $this->reInstallPermission('view');
    }

    public function getCreate()
    {
        return $this->isPermissionByRole('create');
    }

    public function setCreate($value)
    {
        if ($value)
            $this->installPermission('create');
        else
            $this->reInstallPermission('create');
    }

    public function getDelete()
    {
        return $this->isPermissionByRole('delete');
    }

    public function setDelete($value)
    {
        if ($value)
            $this->installPermission('delete');
        else
            $this->reInstallPermission('delete');
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

    public function getPermissionFields()
    {
        return $this->hasMany(PermissionFields::className(), ['id_table' => 'id']);
    }

    public function getPermissionFilters()
    {
        return $this->hasMany(PermissionFilters::className(), ['id_table' => 'id']);
    }
}