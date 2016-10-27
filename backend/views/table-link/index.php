<?
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-table-link").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-table-link"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-table-link'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-table-link'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?=GridView::widget([
    'dataProvider'=> $model->tableLinkDataProvider,
    'id' => 'grid-table-link',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_field',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table-link/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => \yii\helpers\ArrayHelper::map($model->fieldsArray, 'id', 'name')]
            ],
            'value' => function($data){
                return \yii\helpers\ArrayHelper::getValue($data, "field.rus_name");
            },
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_table_ref',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table-link/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => \yii\helpers\ArrayHelper::map(\backend\models\tables\Tables::find()->all(), 'id', 'rus_name')]
            ],
            'value' => function($data){
                return \yii\helpers\ArrayHelper::getValue($data, "tableRef.rus_name");
            },
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_field_ref',
            'editableOptions'=> function($model, $key, $index){
                return [
                    'formOptions' => ['action' => ['/table-link/editrecord']],
                    'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                    'options' => ['data' => $model->fieldRefArray]
                ];
            },
            'value' => function($data){
                return \yii\helpers\ArrayHelper::getValue($data, "fieldRef.rus_name");
            },
            'refreshGrid' => true
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{delete}',
            'controller' => 'table-link',
        ]
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-table-link'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]);?>