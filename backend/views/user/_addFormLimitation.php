<?
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use kartik\helpers\Html;
?>


<?Pjax::begin(['id' => 'pjax-addFormLimitation'])?>
    <?$form = ActiveForm::begin(['id' => 'addFormLimitation5555', 'options' => ['data-pjax' => true]])?>
        <?=$form->field($model, 'id_table')->widget(\kartik\select2\Select2::className(), [
            'data' => $model->getTablesArray(),
            'pluginEvents' => [
                "select2:select" => "function() { $('#addFormLimitation5555').submit(); }",
            ]
        ])?>
        <?if ($model->id_table):?>
            <?=$form->field($model, 'id_field')->widget(\kartik\select2\Select2::className(), [
                'data' => $model->getFieldsArray(),
                'pluginEvents' => [
                    "select2:select" => "function() { $('#addFormLimitation5555').submit(); }",
                ]
            ])?>

            <?if ($model->id_field):?>
                <?=$form->field($model, 'operand')->widget(\kartik\select2\Select2::className(), [
                    'data' => $model->getOperandsArray()
                ])?>

                <?=$this->render('field-limitation/field', ['form' => $form, 'model' => $model])?>

                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success', 'name' => 'addLimitations', 'id' => 'addLimitations']) ?>
                </div>
            <?endif;?>
        <?endif;?>
    <?ActiveForm::end()?>
<?php Pjax::end(); ?>
