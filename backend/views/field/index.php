<?
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use common\models\fields\AqFieldType;

use common\assets\EditablePageAsset;

if ($model->fieldsDataProvider->count == 0)
    EditablePageAsset::register($this);
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-field").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-field"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-field'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-field'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?=GridView::widget([
    'dataProvider'=> $model->fieldsDataProvider,
    'id' => 'grid-fields',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => \backend\models\bd\BD::getArrayFields($model->name)]
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'rus_name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']]
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_type',
            'value' => function($data){
                    return \yii\helpers\ArrayHelper::getValue($data, 'type.name');
            },
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']],
                'inputType' => 'dropDownList',
                'data' => AqFieldType::getAllArray()
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'page_summary',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SWITCH
            ],
            'value' => function($data) {
                return ($data->page_summary)?"on":"off";
            }],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'sort',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']]
            ]
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'controller' => 'field',
            'visibleButtons' => [
                'view' => function($field, $key, $index){
                    if ($field->name == '' || $field->rus_name == '' || $field->id_type == null)
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
            'id' => 'pjax-grid-field'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]);?>
