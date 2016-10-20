<?
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-filter").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-filter"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-filter'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-filter'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?=GridView::widget([
    'dataProvider'=> $model->filtersDataProvider,
    'id' => 'grid-filters',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_field',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/filter/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => \yii\helpers\ArrayHelper::map($model->fieldsArray, 'id', 'name')]
            ],
            'value' => function($data){
                    return \yii\helpers\ArrayHelper::getValue($data, "field.rus_name");
            },
            'refreshGrid' => true
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{delete}',
            'controller' => 'filter',
        ]
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-filter'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]);?>
