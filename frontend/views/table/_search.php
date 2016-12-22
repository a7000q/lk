<?
use kartik\form\ActiveForm;
use kartik\helpers\Html;
?>


    <div class="panel panel-success">
        <div class="panel-heading"><h3>Фильтр</h3></div>
        <div class="panel-body">
            <?$form = ActiveForm::begin(['method' => 'get', 'action' => ['index', 'id' => $searchModel->id_table]])?>
                <?if (count($searchModel->fieldFilters) != 0):?>
                    <?foreach ($searchModel->fieldFilters as $filter):?>
                        <?if ($filter->isGeneral()):?>
                            cd<?=$this->render('search-field/field', ['form' => $form, 'model' => $searchModel, 'filter' => $filter])?>
                        <?endif;?>
                    <?endforeach;?>
                <?endif;?>
                <?=$form->field($searchModel, 'generalInput')?>
                <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'style' => 'width: 100%;']) ?>
            <?ActiveForm::end()?>
        </div>
    </div>


