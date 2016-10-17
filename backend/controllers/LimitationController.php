<?php

namespace backend\controllers;


use backend\models\users\Limitations;
use backend\models\users\Users;
use yii\filters\VerbFilter;
use Yii;

class LimitationController extends CController
{
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax)
        {
            $id_user = $model->id_user;
            $user = Users::findOne($id_user);

            $model->delete();
            $dataProvider = $user->getLimitationsDataProvider();

            return $this->renderAjax('@backend/views/user/gridLimitations', ['dataProvider' => $dataProvider]);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Limitations::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}