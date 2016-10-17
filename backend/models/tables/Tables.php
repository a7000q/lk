<?php

namespace backend\models\tables;

use yii\data\ActiveDataProvider;
use backend\models\fields\Fields;
use yii;
use backend\models\generate\Generate;


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

    static public function getAllArray()
    {
        return yii\helpers\ArrayHelper::map(static::find()->all(), 'id', 'rus_name');
    }

    static public function newTable($id_category)
    {
        $model = new Tables();
        $model->id_category = $id_category;
        $model->save();
    }

    public function beforeSave($insert)
    {
        $this->beforeDeleteClass();
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert)
            $this->addStandartPermissions();

        $this->createClass();

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {
        $this->deleteAllStandartPermission();
        $this->deleteClass();
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

    public function getFieldsArray()
    {
        return yii\helpers\ArrayHelper::getColumn($this->fields, function($element){
            return ['id' => $element->id, 'name' => $element->rus_name];
        });

    }

    private function createClass()
    {
        if ($this->name == "")
            return false;

        $ns = 'frontend\models\table\generate';
        $file_name = $this->getFileNameClass();

        if (file_exists($file_name))
            return false;

        $generator = new Generate();
        $generator->ns = $ns;
        $generator->tableName = $this->name;
        $generator->modelClass = 'Table'.$this->name.$this->id;
        $generator->baseClass = 'frontend\models\table\TableActiveRecords';
        $generator->generateLabelsFromComments = false;

        $files = $generator->generate();

        try {
            foreach ($files as $file)
                $file->save();
        }
        catch (yii\base\Exception $ex)
        {

        }
    }

    private function deleteClass()
    {
        $file_name = $this->getFileNameClass();

        if (!file_exists($file_name))
            return false;

        unlink($file_name);
    }

    private function getFileNameClass()
    {
        return Yii::getAlias("@frontend/models/table/generate").'/Table'.$this->name.$this->id.".php";
    }

    private function beforeDeleteClass()
    {
        $file_name = Yii::getAlias("@frontend/models/table/generate").'/Table'.$this->getOldAttribute('name').$this->id.".php";

        if (!file_exists($file_name))
            return false;

        unlink($file_name);
    }
}