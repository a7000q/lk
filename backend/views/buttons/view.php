<?php
use kartik\detail\DetailView;
use kartik\tabs\TabsX;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use trntv\aceeditor;
use kartik\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => ArrayHelper::getValue($model->table, 'category.name'), 'url' => ['category/view', 'id' => $model->table->id_category]];
$this->params['breadcrumbs'][] = ['label' => $model->table->rus_name, 'url' => ['table/view', 'id' => $model->id_table]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="button-view">

    <?=DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Поле # ' . $model->name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes'=>[
            [
                'attribute' => 'name',
            ],
            [
                'attribute' => 'type',
                'label' => 'Тип',
                'type' => DetailView::INPUT_SELECT2,
                'value' => $model->type,
                'widgetOptions' => [
                    'data' => \backend\models\bd\BD::getButtonsTypes()
                ]

            ],
            [
                'attribute' => 'code',
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => aceeditor\AceEditor::className(),
                    'mode' => 'php'
                ]
            ]
        ],
        'deleteOptions'=>[
            'params' => ['id' => $model->id, 'kvdelete'=>true],
        ],

    ]);?>


</div>



