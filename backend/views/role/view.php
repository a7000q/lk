<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\tabs\TabsX;


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Роли', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Роль # ' . $model->name,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'name',
            'description',
        ],
        'deleteOptions'=>[
            'params' => ['id' => $model->name, 'kvdelete'=>true],
        ],
        'buttons1' => ($model->name != 'admin')?'{update}{delete}':''

    ]) ?>

    <div class="panel panel-primary">
        <div class="panel-heading"><i class="icon-key"></i> Разрешения</div>
        <div class="panel-body">
            <?=TabsX::widget([
                'items'=>[
                    [
                        'label' => 'Таблицы',
                        'content' => $this->render('permissions', ['model' => $model])
                    ]
                ],
                'position'=>TabsX::POS_ABOVE,
                'encodeLabels'=>false
            ]);
            ?>
        </div>
    </div>

</div>
