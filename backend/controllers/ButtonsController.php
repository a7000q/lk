<?php

namespace backend\controllers;

use backend\models\tables\Tables;
use Yii;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use backend\models\buttons\Buttons;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use kartik\helpers\Html;


class ButtonsController extends CController
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Buttons::className(),
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


    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax)
        {
            $table = Tables::findOne($model->id_table);
            $model->delete();

            return $this->renderAjax('index', ['model' => $table]);
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Buttons::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
                            ['/table/view', 'id' => $model->id_table], ['class' => 'btn btn-sm btn-info']) . ' в '.$model->table->rus_name.' .'
                ]
            ]);
            $model->delete();
            return;
        }

        if ($model->load($post) && $model->save())
            Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');

        return $this->render('view', [
            'model' => $model,
        ]);
    }
}