<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\menu\GMenu;
use frontend\models\tables\Tables;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class CController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post']
                ],
            ],
        ];
    }


    public function getMenu()
    {
        $items = GMenu::getList();

        return $this->renderFile('@frontend/views/layouts/main_menu.php', ['items' => $items]);
    }

    protected function findTable($id)
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

        $table = Tables::findOne($id);

        if (!$table)
            throw new NotFoundHttpException('Ошибка в получении ресурса.');

        $class = $table->getClassName();

        $model = new $class;
        $model::$tableBD = $table;

        if ($model) {
            if ($model::$tableBD->isGeneral())
                return $model;
            else
                throw new ForbiddenHttpException('Доступ к данному разделу запрещен!');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
