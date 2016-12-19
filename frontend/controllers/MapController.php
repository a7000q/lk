<?php

namespace frontend\controllers;


class MapController extends CController
{
    public function actionIndex($id)
    {
        $map = $this->findMap($id);

        return $this->render('index', ['map' => $map]);
    }

}