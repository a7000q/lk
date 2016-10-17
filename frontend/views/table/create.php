<?
use kartik\form\ActiveForm;
use kartik\helpers\Html;

$this->title = 'Новая запись в таблице "'.$table->rus_name.'"';
$this->params['breadcrumbs'][] = ['label' => $table->rus_name, 'url' => ['index', 'id' => $table->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="record-form">

        <?php $form = ActiveForm::begin([
        ]); ?>

        <?foreach ($table->fields as $field):?>
            <?=$this->render('field', ['model' => $model, 'field' => $field, 'form' => $form]);?>
        <?endforeach;?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

