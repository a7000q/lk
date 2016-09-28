<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="tables-form">

    <?php $form = ActiveForm::begin([
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            'autoPlaceholder'=>true
        ]
    ]); ?>

    <?= $form->field($model, 'name')->dropDownList(\backend\models\bd\BD::getArrayTables()) ?>

    <?= $form->field($model, 'rus_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
