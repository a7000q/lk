<?php

namespace backend\controllers;

use backend\models\users\AddLimitation;
use backend\models\users\UpdateUser;
use Yii;
use backend\models\users\Users;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\users\AddUser;
use yii\helpers\Json;
use kartik\helpers\Html;
use backend\models\roles\Role;
use backend\models\users\Limitations;

/**
 * UserController implements the CRUD actions for Users model.
 */
class UserController extends CController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'remove-role' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Users::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $user = $this->findModel($id);
        $model = new UpdateUser();
        $model->attributes = $user->attributes;
        $model->_user = $user;
        $model->limitation = new AddLimitation();
        $model->limitation->id_user = $user->id;

        $post = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            if ($model->delete())
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-info' => 'Запись удалена. ' .
                            Html::a('<i class="glyphicon glyphicon-hand-right"></i>  Перейти',
                                ['/user/index'], ['class' => 'btn btn-sm btn-info']) . ' в пользователи.'
                    ]
                ]);
            else
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-error' => 'Невозможно удалить пользователя!'
                    ]
                ]);
            return;
        }

        if ($model->load($post) && $model->update())
            Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');

        if (Yii::$app->request->isAjax && isset($post['role']))
            Role::addRoleByUser($post['role'], $id);

        if (isset($post['AddLimitation']))
        {
            $model->limitation->load($post);

            if (isset($post['addLimitations']))
            {
                $model->limitation->save();
                $model->limitation = new AddLimitation();
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AddUser();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->redirect(['view', 'id' => $model->_user->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->username == 'admin')
            throw new ForbiddenHttpException('Невозможно удалить данного пользователя!');

        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionRemoveRole($id_role, $id_user)
    {
        Role::removeRoleByUser($id_role, $id_user);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
