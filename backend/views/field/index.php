<?
    use kartik\grid\GridView;
    use yii\helpers\Html;
    use kartik\form\ActiveForm;
    use yii\widgets\Pjax;
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
            ]
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'rus_name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']]
            ]
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'sort',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/field/editrecord']]
            ]
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{delete}',
            'controller' => 'field'
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
