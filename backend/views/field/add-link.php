<?
use kartik\form\ActiveForm;
use backend\models\tables\Tables;
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
?>

<?$form = ActiveForm::begin(['id' => 'add-link-form', 'options' => ['data-pjax' => true], 'enableAjaxValidation' => true])?>
    <?=$form->field($model, 'id_table')->dropDownList(Tables::getAllArray(), ['id' => 'id_table', 'prompt' => 'Выберите таблицу'])?>

    <?=$form->field($model, 'id_field_ref')->widget(\kartik\depdrop\DepDrop::className(),
        [
            'options' => ['id' => 'id_field_ref'],
            'data' => ArrayHelper::merge(['Выберите связующее поле'], $model->getFieldsArray()),
            'pluginOptions' => [
                'depends' => ['id_table'],
                'placeholder' => 'Выберите связующее поле',
                'url' => \yii\helpers\Url::toRoute(['subfield'])
            ]
        ]
    )?>

    <?=$form->field($model, 'id_field_visible')->widget(\kartik\depdrop\DepDrop::className(),
        [
            'options' => ['id' => 'id_field_visible'],
            'data' => ArrayHelper::merge(['Выберите отображаемое поле'], $model->getFieldsArray()),
            'pluginOptions' => [
                'depends' => ['id_table'],
                'placeholder' => 'Выберите отображаемое поле',
                'url' => \yii\helpers\Url::toRoute(['subfield'])
            ]
        ]
    )?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
<?ActiveForm::end()?>
