<?
use kartik\form\ActiveForm;
use yii\widgets\Pjax;
use kartik\switchinput\SwitchInput;
?>

<div class="panel panel-success">
    <div class="panel-heading">Действия со страницой</div>
    <div class="panel-body">
        <?Pjax::begin()?>
            <?$form = ActiveForm::begin(['id' => 'general-page-permissions-'.$page->id, 'options' => ['data-pjax' => true, 'class' => 'form-permission']]);?>
                <?=$form->field($page, 'id', ['template' => '{input}'])->hiddenInput()?>
                <?= $form->field($page, 'general')->widget(SwitchInput::classname(), [
                    'type' => SwitchInput::CHECKBOX,
                    'pluginEvents' => [
                        "switchChange.bootstrapSwitch" => "function() { $('#general-page-permissions-".$page->id."').submit(); }"
                    ],
                    'options' => ['id' => 'general-input-page-'.$page->id]
                ]);?>
            <?ActiveForm::end(); ?>
        <?Pjax::end()?>
    </div>
</div>
