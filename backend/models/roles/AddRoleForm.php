<?php

namespace backend\models\roles;


use yii\base\Model;

class AddRoleForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            ['name', 'required'],
            ['name', 'unique', 'targetClass' => '\common\models\auth\AuthItem', 'message' => 'Данная роль уже существует.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание'
        ];
    }

    public function add($auth)
    {
        if (!$this->validate()) {
            return null;
        }

        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        if (!$auth->add($role))
            return null;

        return true;
    }
}