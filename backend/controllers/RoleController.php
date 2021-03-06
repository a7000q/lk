<?php

namespace backend\controllers;


use backend\models\fields\PermissionFields;
use backend\models\filters\PermissionFilters;
use backend\models\maps\PermissionMapPoints;
use backend\models\maps\PermissionMaps;
use backend\models\pages\PermissionPages;
use backend\models\roles\AddRoleForm;
use backend\models\roles\UpdateRoleForm;
use backend\models\tables\PermissionTables;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use kartik\helpers\Html;
use yii\web\ForbiddenHttpException;


/**
 * UserController implements the CRUD actions for Users model.
 */
class RoleController extends CController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $dataProvider = new ArrayDataProvider([
            'allModels' => $auth->roles,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new AddRoleForm();
        $auth = Yii::$app->authManager;

        if ($model->load(Yii::$app->request->post()) && $model->add($auth)) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {
        $auth = Yii::$app->authManager;
        $model = new UpdateRoleForm();
        $model->last_name = $id;
        $model->loadModel($auth);

        $post = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            if ($model->delete($auth))
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-info' => 'Запись удалена. ' .
                            Html::a('<i class="glyphicon glyphicon-hand-right"></i>  Перейти',
                                ['/role/index'], ['class' => 'btn btn-sm btn-info']) . ' в роли.'
                    ]
                ]);
            else
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-error' => 'Невозможно удалить данную роль!'
                    ]
                ]);
            return;
        }

        if (Yii::$app->request->isAjax)
        {
            if (isset($post['PermissionTables'])) {
                $table = $this->findPermissionTable($post['PermissionTables']['id'], $id);
                $table->load($post);
            }

            if (isset($post['PermissionFields'])) {
                $field = $this->findPermissionField($post['PermissionFields']['id'], $id);
                $field->load($post);
            }

            if (isset($post['PermissionFilters'])) {
                $filter = $this->findPermissionFilter($post['PermissionFilters']['id'], $id);
                $filter->load($post);
            }

            if (isset($post['PermissionMaps'])) {
                $map = $this->findPermissionMap($post['PermissionMaps']['id'], $id);
                $map->load($post);
            }

            if (isset($post['PermissionMapPoints'])) {
                $point = $this->findPermissionMapPoint($post['PermissionMapPoints']['id'], $id);
                $point->load($post);
            }

            if (isset($post['PermissionPages'])) {
                $page = $this->findPermissionPages($post['PermissionPages']['id'], $id);
                $page->load($post);
            }

            return $this->renderAjax('view', ['model' => $model]);
        }


        if ($model->load($post) && $model->update($auth))
            Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');

        return $this->render('view', ['model' => $model]);
    }


    public function actionDelete($id)
    {
        $this->deleteRole($id);
        return $this->redirect(['index']);
    }

    private function deleteRole($id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($id);
        if ($id == 'admin')
            throw new ForbiddenHttpException('Невозможно удалить данную роль!');

        $auth->remove($role);
    }

    private function findPermissionTable($id, $role_name)
    {
        $table = PermissionTables::findOne($id);
        $table->role_name = $role_name;

        return $table;
    }

    private function findPermissionField($id, $role_name)
    {
        $field = PermissionFields::findOne($id);
        $field->role_name = $role_name;

        return $field;
    }

    private function findPermissionFilter($id, $role_name)
    {
        $filter = PermissionFilters::findOne($id);
        $filter->role_name = $role_name;

        return $filter;
    }

    private function findPermissionMap($id, $role_name)
    {
        $map = PermissionMaps::findOne($id);
        $map->role_name = $role_name;

        return $map;
    }

    private function findPermissionMapPoint($id, $role_name)
    {
        $point = PermissionMapPoints::findOne($id);
        $point->role_name = $role_name;

        return $point;
    }

    private function findPermissionPages($id, $role_name)
    {
        $page = PermissionPages::findOne($id);
        $page->role_name = $role_name;

        return $page;
    }

}
