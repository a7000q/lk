<?php

namespace frontend\controllers;

use frontend\models\pages\Pages;
use Yii;



class CPageController extends CController
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!Yii::$app->user->isGuest)
            {
                $controller = $action->controller->id;
                $controller = explode("/", $controller);
                $controller = $controller[1];

                $page = Pages::find()->where(['name' => $controller])->one();

                if (!$page || !$page->isGeneral())
                    die($this->render('/site/error', ['name' => 'Ошибка доступа', 'message' => 'Доступ к данному разделу запрещен!']));
            }

            return true; // or false if needed
        } else {
            return false;
        }
    }
}