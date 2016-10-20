<?php

namespace backend\controllers;

use backend\models\bd\BD;
use backend\models\category\Category;
use backend\models\fields\Fields;
use backend\models\filters\Filters;
use Yii;
use backend\models\tables\Tables;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

class TableController extends CController
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Tables::className(),
                'outputValue' => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;
                },
                'outputMessage' => function($model, $attribute, $key, $index) {
                    return '';
                },
                'showModelErrors' => true,
                'errorOptions' => ['header' => ''],
                // 'postOnly' => true,
                'ajaxOnly' => true,
                // 'findModel' => function($id, $action) {},
                // 'checkAccess' => function($action, $model) {}
            ]
        ]);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Tables::find(),
        ]);

        return $this->renderAjax('index', [
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

        if (isset($post['create-filter']))
            Filters::newFilter($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax)
        {
            $category = Category::findOne($model->id_category);
            $model->delete();

            return $this->renderAjax('index', ['model' => $category]);
        }

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
