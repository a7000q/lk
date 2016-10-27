<?php

namespace backend\controllers;

use backend\models\tables\TableLink;
use kartik\grid\EditableColumnAction;
use yii\helpers\ArrayHelper;
use yii;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use kartik\helpers\Html;
use backend\models\tables\Tables;


class TableLinkController extends CController
{
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => TableLink::className(),
                'outputValue' => function ($model, $attribute, $key, $index) {
                    switch ($attribute)
                    {
                        case "id_field":
                            $result = ArrayHelper::getValue($model, "field.rus_name");
                            break;
                        case "id_table_ref":
                            $result = ArrayHelper::getValue($model, "tableRef.rus_name");
                            break;
                        case "id_field_ref":
                            $result = ArrayHelper::getValue($model, "fieldRef.rus_name");
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

    protected function findModel($id)
    {
        if (($model = TableLink::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
