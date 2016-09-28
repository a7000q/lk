<?php

namespace backend\controllers;

use backend\models\bd\BD;
use backend\models\fields\Fields;
use Yii;
use backend\models\tables\Tables;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;

/**
 * TableController implements the CRUD actions for Tables model.
 */
class TableController extends Controller
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
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tables::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
            echo Json::encode([
                'success' => true,
                'messages' => [
                    'kv-detail-info' => 'Запись удалена. ' .
                        Html::a('<i class="glyphicon glyphicon-hand-right"></i>  Перейти',
                            ['/table/index'], ['class' => 'btn btn-sm btn-info']) . ' в категорию.'
                ]
            ]);
            $model->delete();
            return;
        }


        if ($model->load($post) && $model->save())
            Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');

        if (isset($post['create-field']))
            Fields::newField($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Tables model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tables();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tables model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tables the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tables::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
