<?
use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'id' => 'grid-limitations',
    'columns' => [
        'field.table.rus_name',
        'field.rus_name',
        'operand',
        'valueField',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'controller' => 'limitation'
        ],
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-limitation'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>