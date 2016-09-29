<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = $model::$tableBD->rus_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tables-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading'=>'<h3 class="panel-title"> Таблица '.$this->title.'</h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить', ['create', 'id' => $model::$tableBD->id], ['class' => 'btn btn-success']),
            'after'=>false
        ],
        'columns' => $model::$tableBD->gridViewFieldsArray,
        'panelBeforeTemplate' => '{before}{toolbar}',
        'toolbar' => ['{toggleData}']

    ]); ?>
</div>
