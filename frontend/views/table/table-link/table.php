<?
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use common\assets\EditablePageAsset;
EditablePageAsset::register($this);
?>

<?if ($link->tableRef->isCreate()):?>
    <?php
    $this->registerJs(
        '$("document").ready(function(){
                $("#pjax-add-'.$link->tableRef->name.'").on("pjax:end", function() {
                $.pjax.reload({container:"#pjax-grid-'.$link->tableRef->name.'"});  //Reload GridView
            });
        });'
    );
    ?>

    <?Pjax::begin(['id' => 'pjax-add-'.$link->tableRef->name])?>
        <? $form = ActiveForm::begin(['options' => ['data-pjax' => true]]);?>
            <?=Html::submitButton('<i class="glyphicon glyphicon-plus"></i> Добавить', ['class' => 'btn btn-success', 'name' => 'create-record'])?>
            <?=Html::hiddenInput("link", $link->id)?>
        <? ActiveForm::end();?>
    <?Pjax::end()?>
<?endif;?>

<?=GridView::widget([
    'dataProvider'=> $model->getLinkTableLinkDataProvider($link),
    'id' => 'grid-'.$link->tableRef->name,
    'columns' => $link->tableRef->getEditGridViewColumns($link, $link->table->id),
    'pjax'=>true,
    'pjaxSettings'=>[
        'neverTimeout'=>true,
        'options' => [
            'id' => 'pjax-grid-'.$link->tableRef->name
        ]
    ],
    'panelBeforeTemplate' => '{before}'
]);?>
