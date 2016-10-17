<?
use kartik\datetime\DateTimePicker;
?>
<?
    $format = $field->typeDate->format;
    $format = str_replace("Y", "yyyy", $format);

    $field_name = $field->attributeDateName;
?>
<?=$form->field($model, $field_name)->widget(DateTimePicker::className(), [
    'pluginOptions' => [
        'autoclose' => true,
        'format' => $format
    ]
])?>