<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;

?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-page").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-page"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-page'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-page'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?= GridView::widget([
    'dataProvider' => $model->pagesDataProvider,
    'id' => 'grid-pages',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'refreshGrid' => true,
            'editableOptions'=> [
                'formOptions' => ['action' => ['/page/editrecord']],
            ]
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'rus_name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/page/editrecord']],
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'sort',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/page/editrecord']],
            ]
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'controller' => 'page',
            'visibleButtons' => [
                'view' => function($model, $key, $index){
                    if ($model->name == "" || $model->rus_name == "") return false;

                    return true;
                }
            ]
        ],
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-page'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>
