
<?
    switch ($model->field->type->name)
    {
        case "integer":
            echo $this->render('field-integer', ['form' => $form, 'model' => $model]);
            break;
        case "text":
            echo $this->render('field-text', ['form' => $form, 'model' => $model]);
            break;
        case "date":
            echo $this->render('field-date', ['form' => $form, 'model' => $model]);
            break;
        case "link":
            echo $this->render('field-link', ['form' => $form, 'model' => $model]);
            break;
    }
?>