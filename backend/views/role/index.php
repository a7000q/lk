<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роли';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="icon-user"></i> '.$this->title.'</h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Добавить', ['create'], ['class' => 'btn btn-success']),
            'after'=>false,
            'footer'=>false
        ],
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'Название'
            ],
            [
                'attribute' => 'description',
                'label' => 'Описание'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
                'visibleButtons' => [
                    'delete' => function($model, $key, $index){
                        if ($model->name == 'admin') return false;

                        return true;
                    }
                ]
            ],
        ],
        'panelBeforeTemplate' => '{before}'
    ]); ?>
</div>
