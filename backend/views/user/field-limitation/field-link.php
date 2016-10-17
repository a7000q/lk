<?=$form->field($model, 'value')->widget(\kartik\select2\Select2::className(), [
    'data' => $model->field->typeLink->dataArray
])?>