<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\tables\Tables */

$this->title = 'Создание таблицы';
$this->params['breadcrumbs'][] = ['label' => 'Таблицы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tables-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
