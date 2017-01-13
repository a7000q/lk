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

        $generate = new Generator();
        $generate->controllerClass = 'frontend\controllers\page\\'.ucfirst($this->name)."Controller";
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

    public function afterSave($insert, $changedAttributes)
    {
        $this->createController();

        parent::afterSave($insert, $changedAttributes);
    }

    public function getFileNameController()
    {
        return Yii::getAlias("@frontend/controllers/page").'/'.$this->name.$this->id.".php";
    }
}