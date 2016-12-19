<?php
use kartik\detail\DetailView;
use kartik\tabs\TabsX;
use yii\helpers\ArrayHelper;
use common\assets\YandexMapAsset;
use kartik\form\ActiveForm;
use yii\widgets\Pjax;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => ArrayHelper::getValue($model, 'map.category.name'), 'url' => ['category/view', 'id' => $model->map->id_category]];
$this->params['breadcrumbs'][] = ['label' => ArrayHelper::getValue($model, 'map.name'), 'url' => ['maps/view', 'id' => $model->id_map]];
$this->params['breadcrumbs'][] = $this->title;

YandexMapAsset::register($this);

$this->registerJsFile('/js/map/script.js', ['depends' => 'common\assets\YandexMapAsset', 'position' => \yii\web\View::POS_HEAD]);
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-add-point").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-detail-point"});  //Reload GridView
        });
    });'
);
?>

<div class="tables-view">
    <?Pjax::begin(['id' => 'pjax-detail-point'])?>
        <?=DetailView::widget([
            'model'=>$model,
            'condensed'=>true,
            'hover'=>true,
            'mode'=>DetailView::MODE_VIEW,
            'panel'=>[
                'heading'=>'Таблица # ' . $model->name,
                'type'=>DetailView::TYPE_INFO,
            ],
            'attributes'=>[
                'name',
                'description',
                [
                    'attribute' => 'value',
                    'displayOnly' => true,
                    'label' => 'Координаты'
                ]
            ],
            'deleteOptions'=>[
                'params' => ['id' => $model->id, 'kvdelete'=>true],
            ],

        ]);?>
    <?Pjax::end()?>

    <div id="myMap" style="width: 100%; height: 600px"></div>

    <?Pjax::begin(['id' => 'pjax-add-point'])?>
        <?$form = ActiveForm::begin(['options' => ['id' => 'edit-point', 'data-pjax' => true]]);?>
            <?=\kartik\helpers\Html::hiddenInput('coords', $model->value, ['id' => 'point_coords'])?>
        <?ActiveForm::end();?>
    <?Pjax::end()?>

</div>
