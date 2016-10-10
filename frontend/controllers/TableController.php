<?php
namespace frontend\controllers;

use Yii;
use frontend\models\tables\Tables;
use frontend\models\table\TableActiveRecords;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;


class TableController extends CController
{
   public function actionIndex($id)
   {
       $model = $this->findTable($id);

       $dataProvider = new ActiveDataProvider([
           'query' => $model::find(),
       ]);

       return $this->render('index', [
           'dataProvider' => $dataProvider, 'model' => $model
       ]);
   }

    protected function findTable($id)
    {
        if ($model = TableActiveRecords::getTable($id)) {
            if ($model::$tableBD->isGeneral())
                return $model;
            else
                throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
