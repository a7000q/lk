<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\users\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="panel panel-primary">
    <div class="panel-heading"><i class="icon-calendar"></i> Настройка даты</div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'autoPlaceholder'=>true
            ]
        ]); ?>
        <table class="table">
            <tr>
                <td><?= $form->field($model, 'dateFormat') ?></td>
                <td>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                    </div>
                </td>
            </tr>
        </table>
        <?php ActiveForm::end(); ?>
    </div>
</div>

