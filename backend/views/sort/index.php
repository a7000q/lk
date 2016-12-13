<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use common\assets\EditablePageAsset;

if ($model->sortDataProvider->count == 0)
    EditablePageAsset::register($this);

?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-sort").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-sort"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-sort'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-sort'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?= GridView::widget([
    'dataProvider' => $model->sortDataProvider,
    'id' => 'grid-sort',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'id_field',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/sort/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => $model->sortFieldsArray],
            ],
            'value' => function($data)
            {
                return \yii\helpers\ArrayHelper::getValue($data, "field.rus_name");
            }
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'action',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/sort/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => ['1' => 'ASC', '2' => 'DESC']],
            ],
            'value' => function($data){
                return \yii\helpers\ArrayHelper::getValue(['1' => 'ASC', '2' => 'DESC'], $data->action);
            }
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'sort',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/sort/editrecord']],
            ],
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{delete}',
            'controller' => 'sort'
        ],
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-sort'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>
