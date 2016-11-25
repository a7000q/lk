<?php
namespace frontend\controllers;

use frontend\models\fields\Fields;
use frontend\models\table\SearchModel;
use Yii;
use frontend\models\tables\Tables;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

class TableController extends CController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    public function actions()
    {
        $get = Yii::$app->request->get();

        $class = false;
        $id_field = false;
        if (isset($get['id_table_editrecord']))
        {
            $id_table = ArrayHelper::getValue($get, "id_table_editrecord");
            $id_field = ArrayHelper::getValue($get, "id_field_editrecord");
            $table = Tables::findOne($id_table);
            $class = $table->getClassName();
            $class::$tableBD = $table;
        }

        return ArrayHelper::merge(parent::actions(), [
            'editrecord' => [
                'class' => EditableColumnAction::className(),
                'modelClass' => ($class)?$class::className():'',
                'outputValue' => function ($model, $attribute, $key, $index) use ($id_field) {
                    $field = Fields::findOne($id_field);
                    switch ($field->type->name)
                    {
                        case "link":
                            $result = ArrayHelper::getValue($field->typeLink->dataArray, $model->$attribute);
                            break;
                        case "date":
                            $result = date($field->typeDate->format, $model->$attribute);
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
                'errorOptions' => ['header' => ''],
                // 'postOnly' => true,
                // 'ajaxOnly' => true,
                //'findModel' => function($id, $action) {print_r($action);},
                // 'checkAccess' => function($action, $model) {}
            ]
        ]);
    }

    public function actionIndex($id = false)
   {
       if (!$id)
       {
           $tables = Tables::find()->all();

           foreach ($tables as $table)
               if ($table->isGeneral())
               {
                   $id = $table->id;
                   break;
               }
       }

       $model = $this->findTable($id);

       $get = Yii::$app->request->get();

       $searchModel = new SearchModel(['id_table' => $id]);

       $dataProvider = $searchModel->search($get);

       return $this->render('index', [
           'dataProvider' => $dataProvider, 'model' => $model, 'searchModel' => $searchModel
       ]);
   }

   public function actionCreate($id)
   {
       $table = $this->findTable($id);

       if (!$table::$tableBD->isCreate())
           throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');

       $model = new $table;
       $post = Yii::$app->request->post();

       if ($model->load($post) && $model->save())
           $this->redirect(['index', 'id' => $id]);

       return $this->render('create', ['model' => $model, 'table' => $table::$tableBD]);
   }

   public function actionDelete($id, $id_table)
   {
       $model = $this->findTable($id_table);

       if (!$model::$tableBD->isDelete())
           throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');

       $record = $model::find($id)->one();

       if (!$record)
           throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');

       $record->delete();
       $this->redirect(['index', 'id' => $id_table]);
   }

   public function actionView($id, $id_table)
   {
       $table = $this->findTable($id_table);

       if (!$table::$tableBD->isView())
           throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');

       $model = $table::findOne($id);

       if (!$model)
           throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');

       $post = Yii::$app->request->post();

       if (Yii::$app->request->isAjax && isset($post['kvdelete'])) {
           echo Json::encode([
               'success' => true,
               'messages' => [
                   'kv-detail-info' => 'Запись удалена. ' .
                       Html::a('<i class="glyphicon glyphicon-hand-right"></i>  Перейти',
                           ['/table/index', 'id' => $table::$tableBD->id], ['class' => 'btn btn-sm btn-info']) . ' в таблицу "'.$table::$tableBD->rus_name.'"'
               ]
           ]);
           $model->delete();
           return;
       }


       if ($model->load($post) && $model->save())
           Yii::$app->session->setFlash('kv-detail-success', 'Запись сохранена!');

       return $this->render('view', ['model' => $model, 'table' => $table::$tableBD]);
   }


}
