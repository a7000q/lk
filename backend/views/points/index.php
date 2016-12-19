<?
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;

use common\assets\EditablePageAsset;

if ($model->pointsDataProvider->count == 0)
    EditablePageAsset::register($this);
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-point").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-point"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-point'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-point'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?=GridView::widget([
    'dataProvider'=> $model->pointsDataProvider,
    'id' => 'grid-point',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/points/editrecord']],
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'description',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/points/editrecord']]
            ],
            'refreshGrid' => true
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'controller' => 'points',
            'visibleButtons' => [
                'view' => function($field, $key, $index){
                    if ($field->name == '')
                        return false;

                    return true;
                }
            ]
        ]
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-point'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]);?>
