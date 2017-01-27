<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use common\assets\EditablePageAsset;

if ($model->tablesDataProvider->count == 0)
    EditablePageAsset::register($this);

    ?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-table").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-table"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-table'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-table'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?= GridView::widget([
    'dataProvider' => $model->tablesDataProvider,
    'id' => 'grid-tables',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => \backend\models\bd\BD::getArrayTables()],
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'rus_name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table/editrecord']],
            ],
            'refreshGrid' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'sort',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/table/editrecord']],
            ]
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'controller' => 'table',
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
            'id' => 'pjax-grid-table'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>
