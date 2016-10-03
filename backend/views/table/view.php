<?php
use kartik\detail\DetailView;
use kartik\tabs\TabsX;
use yii\helpers\ArrayHelper;

$this->title = $model->rus_name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['category/index']];
$this->params['breadcrumbs'][] = ['label' => ArrayHelper::getValue($model, 'category.name'), 'url' => ['category/view', 'id' => $model->id_category]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tables-view">

    <?=DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Таблица # ' . $model->rus_name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes'=>[
            [
                'attribute' => 'name',
                'type' => DetailView::INPUT_SELECT2,
                'widgetOptions' => [
                    'data' => \backend\models\bd\BD::getArrayTables()
                ]
            ],
            'rus_name',
            'sort'
        ],
        'deleteOptions'=>[
            'params' => ['id' => $model->id, 'kvdelete'=>true],
        ],

    ]);?>

    <?=TabsX::widget([
        'items'=>[
            [
                'label' => 'Поля',
                'content' => $this->render('@backend/views/field/index.php', ['model' => $model])
            ]
        ],
        'position'=>TabsX::POS_LEFT,
        'encodeLabels'=>false
    ]);
    ?>

</div>
