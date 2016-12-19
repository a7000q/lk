<?
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use kartik\switchinput\SwitchInput;
?>

<div class="panel panel-success">
    <div class="panel-heading">Действия с картой</div>
    <div class="panel-body">
        <?Pjax::begin()?>
            <?$form = ActiveForm::begin(['id' => 'general-map-permissions-'.$map->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                <?=$form->field($map, 'id', ['template' => '{input}'])->hiddenInput()?>
                <?= $form->field($map, 'general')->widget(SwitchInput::classname(), [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginEvents' => [
                        "switchChange.bootstrapSwitch" => "function() { $('#general-map-permissions-".$map->id."').submit(); }"
                    ],
                    'options' => ['id' => 'general-input-map-'.$map->id]
                ]);?>
            <?ActiveForm::end(); ?>
        <?Pjax::end()?>
    </div>
</div>

<div class="panel panel-success">
    <div class="panel-heading">Действия с точками</div>
    <div class="panel-body">
        <?Pjax::begin()?>
            <table class="table table-bordered">
                <tr>
                    <td><b>Название точки</b></td>
                    <td><b>Доступность</b></td>
                </tr>
                <?foreach ($map->permissionMapPoints as $point):?>
                    <?$point->role_name = $map->role_name;?>
                    <tr>
                        <td><?=$point->name?></td>
                        <td>
                            <?$form = ActiveForm::begin(['id' => 'general-point-permissions-'.$point->id, 'options' => ['data-pjax' => true]]);?>
                                <?=$form->field($point, 'id', ['template' => '{input}'])->hiddenInput()?>
                                <?= $form->field($point, 'general', ['template' => '{input}'])->widget(SwitchInput::classname(), [
                                    'type' => SwitchInput::CHECKBOX,
                                    'pluginEvents' => [
                                        "switchChange.bootstrapSwitch" => "function() { $('#general-point-permissions-".$point->id."').submit(); }"
                                    ],
                                    'options' => ['id' => 'general-input-point-'.$point->id]
                                ]);?>
                            <?ActiveForm::end(); ?>
                        </td>
                    </tr>
                <?endforeach;?>
            </table>
        <?Pjax::end()?>
    </div>
</div>