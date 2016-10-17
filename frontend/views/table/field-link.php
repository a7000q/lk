<?
use kartik\select2\Select2;
?>
<?=$form->field($model, $field->attributeName)->widget(Select2::className(), [
    'data' => $field->typeLink->dataArray
])?>
