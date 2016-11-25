<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use common\assets\EditablePageAsset;

if ($model->buttonsDataProvider->count == 0)
    EditablePageAsset::register($this);

?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-button").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-button"});  //Reload GridView
        });
    });'
);
?>

<?Pjax::begin(['id' => 'pjax-add-button'])?>
    <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
        <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-button'])?>
    <? ActiveForm::end();?>
<?Pjax::end()?>

<?= GridView::widget([
    'dataProvider' => $model->buttonsDataProvider,
    'id' => 'grid-buttons',
    'columns' => [
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'name',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/buttons/editrecord']],
            ],
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'type',
            'editableOptions'=> [
                'formOptions' => ['action' => ['/buttons/editrecord']],
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'options' => ['data' => \backend\models\bd\BD::getButtonsTypes()],
            ],
        ],
        [
            'class' => '\kartik\grid\ActionColumn',
            'template' => '{view}{delete}',
            'controller' => 'buttons'
        ],
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-button'
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]); ?>
