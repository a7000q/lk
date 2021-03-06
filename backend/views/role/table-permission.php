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
            <table class="table table-bordered">
                <tr>
                    <td><b>Название поля</b></td>
                    <td><b>Доступность</b></td>
                    <td><b>Редактирование</b></td>
                </tr>
                <?foreach ($table->permissionFields as $field):?>
                    <?$field->role_name = $table->role_name;?>
                    <tr>
                        <td><?=$field->rus_name?></td>
                        <td>
                            <?$form = ActiveForm::begin(['id' => 'general-field-permissions-'.$field->id, 'options' => ['data-pjax' => true]]);?>
                                <?=$form->field($field, 'id', ['template' => '{input}'])->hiddenInput()?>
                                <?= $form->field($field, 'general', ['template' => '{input}'])->widget(SwitchInput::classname(), [
                                    'type' => SwitchInput::CHECKBOX,
                                    'pluginEvents' => [
                                        "switchChange.bootstrapSwitch" => "function() { $('#general-field-permissions-".$field->id."').submit(); }"
                                    ],
                                    'options' => ['id' => 'general-input-field-'.$field->id]
                                ]);?>
                            <?ActiveForm::end(); ?>
                        </td>
                        <td>
                            <?if ($field->general):?>
                                <?$form = ActiveForm::begin(['id' => 'update-field-permissions-'.$field->id, 'options' => ['data-pjax' => true]]);?>
                                <?=$form->field($field, 'id', ['template' => '{input}'])->hiddenInput()?>
                                <?= $form->field($field, 'update', ['template' => '{input}'])->widget(SwitchInput::classname(), [
                                    'type' => SwitchInput::CHECKBOX,
                                    'pluginEvents' => [
                                        "switchChange.bootstrapSwitch" => "function() { $('#update-field-permissions-".$field->id."').submit(); }"
                                    ],
                                    'options' => ['id' => 'update-input-field-'.$field->id]
                                ]);?>
                                <?ActiveForm::end(); ?>
                            <?endif;?>
                        </td>
                    </tr>
                <?endforeach;?>
            </table>
        <?Pjax::end()?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">Действия с фильтрами</div>
    <div class="panel-body">
        <?Pjax::begin()?>
        <table class="table table-bordered">
            <tr>
                <td><b>Поле</b></td>
                <td><b>Доступность</b></td>
            </tr>
            <?foreach ($table->permissionFilters as $filter):?>
                <?$filter->role_name = $table->role_name;?>
                <tr>
                    <td><?=$filter->field->rus_name?></td>
                    <td>
                        <?$form = ActiveForm::begin(['id' => 'general-filter-permissions-'.$filter->id, 'options' => ['data-pjax' => true]]);?>
                        <?=$form->field($filter, 'id', ['template' => '{input}'])->hiddenInput()?>
                        <?= $form->field($filter, 'general', ['template' => '{input}'])->widget(SwitchInput::classname(), [
                            'type' => SwitchInput::CHECKBOX,
                            'pluginEvents' => [
                                "switchChange.bootstrapSwitch" => "function() { $('#general-filter-permissions-".$filter->id."').submit(); }"
                            ],
                            'options' => ['id' => 'general-input-filter-'.$filter->id]
                        ]);?>
                        <?ActiveForm::end(); ?>
                    </td>
                </tr>
            <?endforeach;?>
        </table>
        <?Pjax::end()?>
    </div>
</div>