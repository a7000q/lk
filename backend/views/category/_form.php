<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'autoPlaceholder'=>true
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
