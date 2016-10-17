<?php
namespace backend\models\users;

use yii\base\Model;
use backend\models\users\Users;

class UpdateUser extends Model
{
    public $username;
    public $email;
    public $password = null;
    public $id;

    public $_user;
    public $limitation;

    public function rules()
    {
        return [
            ['id', 'integer'],
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль'
        ];
    }

    public function update()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = Users::findOne($this->id);
        $user->username = $this->username;
        $user->email = $this->email;
        if ($this->password != null)
            $user->setPassword($this->password);
        $user->generateAuthKey();

        $this->_user = $user;

        return $user->save();
    }

    public function delete()
    {
        $user = Users::findOne($this->id);
        if ($user->username != 'admin')
            return $user->delete();
        else
            return false;
    }
}
