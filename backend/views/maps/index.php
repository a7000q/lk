<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use common\assets\EditablePageAsset;

if ($model->mapsDataProvider->count == 0)
    EditablePageAsset::register($this);

?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-map").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-map"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-map'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-map'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?= GridView::widget([
    'dataProvider' => $model->mapsDataProvider,
    'id' => 'grid-maps',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/maps/editrecord']],
            ],
            'refreshGrid' => true
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'controller' => 'maps',
            'visibleButtons' => [
                'view' => function($model, $key, $index){
                    if ($model->name == "") return false;

                    return true;
                }
            ]
        ],
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-map'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>
