<?
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use kartik\switchinput\SwitchInput;
?>

<style>
    .form-permission{
        width: 10%;
        float: left;
    }
</style>

<div class="panel panel-success">
    <div class="panel-heading">Действия с таблицой</div>
    <div class="panel-body">
        <?Pjax::begin()?>
            <?$form = ActiveForm::begin(['id' => 'general-table-permissions-'.$table->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                <?=$form->field($table, 'id', ['template' => '{input}'])->hiddenInput()?>
                <?= $form->field($table, 'general')->widget(SwitchInput::classname(), [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginEvents' => [
                        "switchChange.bootstrapSwitch" => "function() { $('#general-table-permissions-".$table->id."').submit(); }"
                    ],
                    'options' => ['id' => 'general-input-table-'.$table->id]
                ]);?>
            <?ActiveForm::end(); ?>
                <?if ($table->general):?>
                    <?$form = ActiveForm::begin(['id' => 'view-table-permissions-'.$table->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                        <?=$form->field($table, 'id', ['template' => '{input}'])->hiddenInput()?>
                        <?= $form->field($table, 'view')->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginEvents' => [
                                "switchChange.bootstrapSwitch" => "function() { $('#view-table-permissions-".$table->id."').submit(); }"
                            ],
                            'options' => ['id' => 'view-input-table-'.$table->id]
                        ]);?>
                    <?ActiveForm::end(); ?>
                    <?$form = ActiveForm::begin(['id' => 'create-table-permissions-'.$table->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                        <?=$form->field($table, 'id', ['template' => '{input}'])->hiddenInput()?>
                        <?= $form->field($table, 'create')->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginEvents' => [
                                "switchChange.bootstrapSwitch" => "function() { $('#create-table-permissions-".$table->id."').submit(); }"
                            ],
                            'options' => ['id' => 'create-input-table-'.$table->id]
                        ]);?>
                    <?ActiveForm::end(); ?>
                    <?$form = ActiveForm::begin(['id' => 'update-table-permissions-'.$table->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                        <?=$form->field($table, 'id', ['template' => '{input}'])->hiddenInput()?>
                        <?= $form->field($table, 'update')->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginEvents' => [
                                "switchChange.bootstrapSwitch" => "function() { $('#update-table-permissions-".$table->id."').submit(); }"
                            ],
                            'options' => ['id' => 'update-input-table-'.$table->id]
                        ]);?>
                    <?ActiveForm::end(); ?>
                    <?$form = ActiveForm::begin(['id' => 'delete-table-permissions-'.$table->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                        <?=$form->field($table, 'id', ['template' => '{input}'])->hiddenInput()?>
                        <?= $form->field($table, 'delete')->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginEvents' => [
                                "switchChange.bootstrapSwitch" => "function() { $('#delete-table-permissions-".$table->id."').submit(); }"
                            ],
                            'options' => ['id' => 'delete-input-table-'.$table->id]
                        ]);?>
                    <?ActiveForm::end(); ?>
        <?endif;?>
        <?Pjax::end()?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">Действия с полями</div>
    <div class="panel-body">
        <?Pjax::begin()?>

        <?Pjax::end()?>
    </div>
</div>