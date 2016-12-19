<?php

namespace backend\controllers;


use backend\models\maps\MapPoints;
use backend\models\maps\Maps;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\Html;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;

class PointsController extends CController
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => MapPoints::className(),
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
            'query' => MapPoints::find(),
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

        if (isset($post["create-point"]))
            MapPoints::newPoint($model->id);

        if (isset($post["coords"]) && $post["coords"] != "")
        {
            $model->value = $post["coords"];
            $model->save();
        }


        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax)
        {
            $category = Maps::findOne($model->id_map);
            $model->delete();

            return $this->renderAjax('index', ['model' => $category]);
        }

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = MapPoints::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
