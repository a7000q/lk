<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="icon-briefcase"></i> Категории</h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']),
            'after'=>false,
            'footer'=>false
        ],
        'columns' => [
            'name',
            'sort',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}'
            ],
        ],
        'panelBeforeTemplate' => '{before}'
    ]); ?>
</div>
