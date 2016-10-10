<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model backend\models\users\Users */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Пользователь # ' . $model->username,
            'type'=>DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'username',
            'email:email',
            'password'
        ],
        'deleteOptions'=>[
            'params' => ['id' => $model->id, 'kvdelete'=>true],
        ],
        'buttons1' => ($model->username != 'admin')?'{update}{delete}':''
    ]) ?>

    <?=TabsX::widget([
        'items'=>[
            [
                'label' => 'Роли',
                'content' => $this->render('roles', ['model' => $model])
            ]
        ],
        'position'=>TabsX::POS_LEFT,
        'encodeLabels'=>false
    ]);
    ?>

</div>
