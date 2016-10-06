<?php

namespace backend\models\roles;


use yii\base\Model;

class UpdateRoleForm extends Model
{
    public $name;
    public $description;

    public $last_name;
    public $auth;


    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            ['name', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'description' => 'Описание',
        ];
    }

    public function loadModel($auth)
    {
        $role = $auth->getRole($this->last_name);
        $this->name = $role->name;
        $this->description = $role->description;
        $this->auth = $auth;

    }

    public function update($auth)
    {
        if (!$this->validate()) {
            return null;
        }

        $role = $auth->getRole($this->last_name);
        $role->name = $this->name;
        $role->description = $this->description;

        if (!$auth->update($this->last_name, $role))
            return null;

        return true;
    }

    public function delete($auth)
    {
        $role = $auth->getRole($this->last_name);
        if ($this->last_name != 'admin')
            return $auth->remove($role);
        else
            return false;
    }
}