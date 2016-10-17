<?
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use yii\widgets\Pjax;
?>

<div class="panel panel-primary">
    <div class="panel-heading"><i class="icon-link"></i> Настройка связи</div>
    <div class="panel-body">
        <?Pjax::begin(['enablePushState' => false])?>
            <?if ($model->typeLink):?>
                <table class="table">
                    <tr>
                        <td>Таблица</td>
                        <td><b><?=$model->typeLink->refTable->rus_name?></b></td>
                    </tr>
                    <tr>
                        <td>Связующее поле</td>
                        <td><b><?=$model->typeLink->fieldRef->rus_name?></b></td>
                    </tr>
                    <tr>
                        <td>Отображаемое поле</td>
                        <td><b><?=$model->typeLink->fieldVisible->rus_name?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?$form = ActiveForm::begin(['options' => ['data-pjax' => true], 'action' => ['install-link', 'id' => $model->id]]);?>
                                <?=Html::submitButton('Изменить', ['class' => 'btn btn-success', 'name' => 'update-link', 'style' => 'width: 100%'])?>
                            <?ActiveForm::end();?>
                        </td>
                    </tr>
                </table>
            <?else:?>
                <h4>Связь не установлена!</h4> <br>
                <?$form = ActiveForm::begin(['options' => ['data-pjax' => true], 'action' => ['install-link', 'id' => $model->id]]);?>
                    <?=Html::submitButton('Установить', ['class' => 'btn btn-success', 'name' => 'create-link'])?>
                <?ActiveForm::end();?>
            <?endif;?>
        <?Pjax::end()?>
    </div>
</div>

