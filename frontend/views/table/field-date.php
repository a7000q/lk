<?
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;
?>
<?
    $format = ArrayHelper::getValue($field, "typeDate.format", "d.m.Y");
    $format = str_replace("Y", "yyyy", $format);

    $field_name = $field->attributeDateName;
?>
<?=$form->field($model, $field_name)->widget(DateTimePicker::className(), [
    'pluginOptions' => [
        'autoclose' => true,
        'format' => $format
    ]
])?>