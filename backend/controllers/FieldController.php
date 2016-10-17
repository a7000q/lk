<?php

namespace backend\controllers;

use backend\models\fields\LinkType;
use backend\models\tables\Tables;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;
use backend\models\fields\Fields;
use yii;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use kartik\helpers\Html;

class FieldController extends CController
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Fields::className(),
                'outputValue' => function ($model, $attribute, $key, $index) {
                    switch ($attribute)
                    {
                        case "id_type":
                            $result = ArrayHelper::getValue($model, "type.name");
                            break;
                        default:
                            $result = $model->$attribute;
                            break;
                    }
                    return  $result;
                },
                'outputMessage' => function($model, $attribute, $key, $index) {
                    return '';
                },
                'showModelErrors' => true,
                'errorOptions' => ['header' => '']
                // 'postOnly' => true,
                // 'ajaxOnly' => true,
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
                            ['/table/view', 'id' => $model->id_table], ['class' => 'btn btn-sm btn-info']) . ' в родительскую таблицу.'
                ]
            ]);
            $model->delete();
            return;
        }

        if ($model->load($post) && $model->save())
        {
            Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');
            $model = $this->findModel($id);
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionInstallLink($id)
    {
        $model = new LinkType();
        $model->id_field = $id;

        $post = Yii::$app->request->post();

        if (isset($post['update-link']))
            $model->loadFieldLink();

        if (isset($post['LinkType']))
        {
            $model->load($post);
            if ($model->validate() && $model->save())
                $this->redirect(['view', 'id' => $id]);
        }


        return $this->renderAjax('add-link', ['model' => $model]);
    }

    public function actionSubfield()
    {
        $post = Yii::$app->request->post();
        $out = [];
        if (isset($post['depdrop_parents']))
        {
            $id_table = $post['depdrop_parents'][0];
            $table = Tables::findOne($id_table);

            $out = $table->getFieldsArray();

            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
        }

    }

    protected function findModel($id)
    {
        if (($model = Fields::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
