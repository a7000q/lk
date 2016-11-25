<?
use kartik\grid\GridView;
?>




<?=GridView::widget([
    'dataProvider'=> $model->getLinkTableLinkDataProvider($link),
    'id' => 'grid-'.$link->tableRef->name,
    'columns' => $link->tableRef->getEditGridViewColumns($link),
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-'.$link->tableRef->name
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]);?>
