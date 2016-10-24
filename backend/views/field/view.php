<?php
use kartik\detail\DetailView;
use kartik\tabs\TabsX;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use trntv\aceeditor;
use kartik\helpers\Html;

$this->title = $model->rus_name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => ArrayHelper::getValue($model->table, 'category.name'), 'url' => ['category/view', 'id' => $model->table->id_category]];
$this->params['breadcrumbs'][] = ['label' => $model->table->rus_name, 'url' => ['table/view', 'id' => $model->id_table]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fields-view">

    <?=DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Поле # ' . $model->rus_name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes'=>[
            [
                'attribute' => 'name',
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => \backend\models\bd\BD::getArrayFields($model->table->name)
                ]
            ],
            'rus_name',
            [
                'attribute' => 'id_type',
                'label' => 'Тип',
                'type' => DetailView::INPUT_SELECT2,
                'value' => $model->type->name,
                'widgetOptions' => [
                    'data' => \common\models\fields\AqFieldType::getAllArray()
                ]

            ],
            'sort'
        ],
        'deleteOptions'=>[
            'params' => ['id' => $model->id, 'kvdelete'=>true],
        ],

    ]);?>

    <?
        switch ($model->type->name):
            case "date":
                echo $this->render('date', ['model' => $model]);
                break;
            case "link":
                echo $this->render('link', ['model' => $model]);
                break;
            case "calculate":
                echo $this->render('calculate', ['model' => $model]);
                break;
            default:
                break;
        endswitch;
    ?>

</div>
