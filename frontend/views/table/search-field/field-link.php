<?
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
?>
<?=$form->field($model, $filter->field->attributeName)->widget(Select2::className(), [
    'data' => ArrayHelper::merge(['Все'], $filter->field->typeLink->dataArray)
])?>