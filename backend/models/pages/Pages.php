<?php

namespace backend\models\pages;


use common\models\pages\AqPages;
use Yii;
use yii\gii\generators\controller\Generator;
use yii\base\Exception;

class Pages extends AqPages
{
    static public function newPage($id_category)
    {
        $page = new Pages();
        $page->id_category = $id_category;
        $page->save();
    }

    public function createController()
    {
        if ($this->name == "")
            return false;

        $file_name = $this->getFileNameController();

        if (file_exists($file_name))
            return false;

        $dir = Yii::getAlias('@frontend/views/page/'.$this->name);

        if(!is_dir($dir)) mkdir($dir, 0777);

        $oldumask = umask(0);
        chmod($dir, 0777);
        umask($oldumask);

        $generate = new Generator();
        $generate->controllerClass = 'frontend\controllers\page\\'.ucfirst($this->name)."Controller";
        $generate->baseClass = 'frontend\controllers\CPageController';
        $generate->viewPath = '@frontend/views/page/'.$this->name;
        $files = $generate->generate();

        try {
            foreach ($files as $file)
                $file->save();
        }
        catch (Exception $ex)
        {
        }
    }

    public function beforeSave($insert)
    {
        $this->beforeDeleteController();
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
            $this->addStandartPermissions();

        $this->createController();

        parent::afterSave($insert, $changedAttributes);
    }

    public function addStandartPermissions()
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

    public function beforeDelete()
    {
        $this->deleteController();
        $this->deleteAllStandartPermission();
        return parent::beforeDelete();
    }

    private function deleteAllStandartPermission()
    {
        $this->removePermission('general');
    }


    private function removePermission($name)
    {
        $auth = Yii::$app->authManager;
        $permission_name = $this->getPermissionName($name);

        $permission = $auth->getPermission($permission_name);

        if ($permission != null)
            $auth->remove($permission);
    }

    public function getFileNameController()
    {
        return Yii::getAlias("@frontend/controllers/page").'/'.$this->name.$this->id.".php";
    }

    public function beforeDeleteController()
    {
        if ($this->name != $this->getOldAttribute("name") && $this->getOldAttribute("name"))
        {
            $file_name_old = Yii::getAlias("@frontend/controllers/page/".$this->getOldAttribute("name")."Controller.php");
            $file_name_new = Yii::getAlias("@frontend/controllers/page/".ucfirst($this->name)."Controller.php");

            $view_path_old = Yii::getAlias("@frontend/views/page/".$this->getOldAttribute("name"));
            $view_path_new = Yii::getAlias("@frontend/views/page/".$this->name);

            rename($file_name_old, $file_name_new);
            rename($view_path_old, $view_path_new);
        }

    }

    public function deleteController()
    {
        $controller_file = Yii::getAlias("@frontend/controllers/page/".ucfirst($this->name)."Controller.php");
        $view_path = Yii::getAlias("@frontend/views/page/".$this->name);

        if (file_exists($controller_file))
            unlink($controller_file);

        if (is_dir($view_path))
            rmdir($view_path);

        return true;
    }

}