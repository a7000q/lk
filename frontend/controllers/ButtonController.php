<?php

namespace frontend\controllers;


use frontend\models\buttons\Buttons;
use yii\web\NotFoundHttpException;
use Yii;

class ButtonController extends CController
{
    public function actionRun($id_button, $id)
    {
        $button = $this->findButton($id_button);
        $model = $this->findTable($button->id_table);
        $model = $model::findOne($id);
        eval($button->code);
        $this->redirect(Yii::$app->request->referrer);
    }

    protected function findButton($id)
    {
        if (($model = Buttons::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}