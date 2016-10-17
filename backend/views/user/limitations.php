<?
use kartik\grid\GridView;
?>

<?php
$this->registerJs(
    '$("document").ready(function(){
            $("#pjax-addFormLimitation").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-grid-limitation"});  //Reload GridView
        });
    });'
);
?>

<div class="panel panel-success">
    <div class="panel-heading">Ограничения на пользователя</div>
    <div class="panel-body">

        <?=$this->render('_addFormLimitation', ['model' => $model->limitation]);?>

        <?=$this->render('gridLimitations', ['dataProvider' => $model->_user->getLimitationsDataProvider()])?>
    </div>
</div>