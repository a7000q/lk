<?
use kartik\daterange\DateRangePicker;
?>
<?=$form->field($model, $filter->field->attributeDateName)->widget(DateRangePicker::className(), [
    'pluginOptions' => [
        'locale' => [
            'format' => 'DD.MM.Y',
        ],
    ]
])?>