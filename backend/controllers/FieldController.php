<?php

namespace backend\controllers;

use backend\models\tables\Tables;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;
use backend\models\fields\Fields;
use yii;

class FieldController extends \yii\web\Controller
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => Fields::className(),
                'outputValue' => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;
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

    protected function findModel($id)
    {
        if (($model = Fields::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
