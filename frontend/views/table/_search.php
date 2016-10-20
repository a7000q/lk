<?
use kartik\form\ActiveForm;
use kartik\helpers\Html;
?>

<?if (count($searchModel->fieldFilters) != 0):?>
    <div class="panel panel-success">
        <div class="panel-heading"><h3>Фильтр</h3></div>
        <div class="panel-body">
            <?$form = ActiveForm::begin(['method' => 'get', 'action' => ['index', 'id' => $searchModel->id_table]])?>
                <?foreach ($searchModel->fieldFilters as $filter):?>
                    <?=$this->render('search-field/field', ['form' => $form, 'model' => $searchModel, 'filter' => $filter])?>
                <?endforeach;?>
                <?= Html::submitButton('Искать', ['class' => 'btn btn-primary', 'style' => 'width: 100%;']) ?>
            <?ActiveForm::end()?>
        </div>
    </div>
<?endif;?>

