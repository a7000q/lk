<?php

use kartik\detail\DetailView;
use kartik\tabs\TabsX;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Категория # ' . $model->name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes'=>[
            'name',
            'sort'
        ],
        'deleteOptions'=>[
            'params' => ['id' => $model->id, 'kvdelete'=>true],
        ],

    ]) ?>

    <?=TabsX::widget([
        'items'=>[
            [
                'label' => 'Таблицы',
                'content' => $this->render('@backend/views/table/index.php', ['model' => $model])
            ],
            [
                'label' => 'Карты',
                'content' => $this->render('@backend/views/maps/index.php', ['model' => $model])
            ],
            [
                'label' => 'Страницы',
                'content' => $this->render('@backend/views/pages/index.php', ['model' => $model])
            ]
        ],
        'position'=>TabsX::POS_LEFT,
        'encodeLabels'=>false
    ]);
    ?>



</div>
