<?php

use kartik\detail\DetailView;
use kartik\tabs\TabsX;

$this->title = 'Запись в таблице "'.$table->rus_name.'"';
$this->params['breadcrumbs'][] = ['label' => $table->rus_name, 'url' => ['index', 'id' => $table->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="table-view">
    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'buttons1' => ($table->isUpdate()?'{update}':'').($table->isDelete()?'{delete}':''),
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Таблица # ' . $table->rus_name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes'=>$model::$tableBD->getDetailViewAttributesArray($model),
        'deleteOptions'=>[
            'params' => ['id' => $model->id, 'kvdelete'=>true],
        ],

    ]) ?>
</div>
