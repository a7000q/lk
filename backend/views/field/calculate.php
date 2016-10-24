<?
use kartik\form\ActiveForm;
use trntv\aceeditor;
use kartik\helpers\Html;
?>

<div class="panel panel-success">
    <div class="panel-heading">Скрипт просмотра</div>
    <div class="panel-body">
        <?if ($model->scriptView):?>
            <?$form = ActiveForm::begin(['action' => ['update-script', 'id_script' => $model->scriptView->id]])?>
            <?=$form->field($model->scriptView, 'code', ['template' => '{input}{error}'])->widget(aceeditor\AceEditor::className(), ['mode' => 'php'])?>
            <?=Html::submitButton('Сохранить', ['name' => 'save', 'class' => 'btn btn-success'])?>
            <?ActiveForm::end()?>
        <?else:?>
            <?=Html::a('Добавить', ['add-script', 'id_field' => $model->id, 'type' => 'view'], ['class' => 'btn btn-success'])?>
        <?endif;?>
    </div>
</div>