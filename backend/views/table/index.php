<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Таблицы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tables-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="icon-briefcase"></i> Таблицы</h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']),
            'after'=>false,
            'footer'=>false
        ],
        'columns' => [
            'name',
            'rus_name',
            'sort',
            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{view}{delete}'
            ],
        ],
        'panelBeforeTemplate' => '{before}'

    ]); ?>
</div>
