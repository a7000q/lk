<?php

namespace backend\controllers;

use backend\models\maps\Maps;
use backend\models\tables\Tables;
use Yii;
use backend\models\category\Category;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\ConflictHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;


class CategoryController extends CController
{

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();

        if (Yii::$app->request->isAjax && isset($post['kvdelete']))
            $this->modelDelete($id);

        if ($model->load($post) && $model->save())
            Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');

        if (isset($post['create-table']))
            Tables::newTable($id);

        if (isset($post['create-map']))
            Maps::newMap($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

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
        $this->modelDelete($id);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function modelDelete($id)
    {
        if (!Yii::$app->request->isAjax) {
            try {
                $this->findModel($id)->delete();
            } catch (Exception $ex) {
                throw new NotFoundHttpException('Невозможно удалить категорию!');
            }
        }
        else{
            try {
                $model = $this->findModel($id);
                $model->delete();
            }
            catch (Exception $ex){
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-error' => 'Категория не может быть удалена!'
                    ]
                ]);
                return;
            }

            echo Json::encode([
                'success' => true,
                'messages' => [
                    'kv-detail-info' => 'Запись удалена. ' .
                        Html::a('<i class="glyphicon glyphicon-hand-right"></i>  Перейти',
                            ['/category/index'], ['class' => 'btn btn-sm btn-info']) . ' в категории.'
                ]
            ]);
            return;
        }
    }
}
