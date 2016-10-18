<?
use kartik\datetime\DateTimePicker;
?>
<?
$format = $model->field->typeDate->format;
$format = str_replace("Y", "yyyy", $format);

?>
<?=$form->field($model, 'value')->widget(DateTimePicker::className(), [
    'pluginOptions' => [
        'autoclose' => true,
        'format' => $format
    ]
])?>