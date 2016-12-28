<?if ($field->isUpdate()):?>
    <?
        switch ($field->type->name)
        {
            case "integer":
                echo $this->render('field-integer', ['model' => $model, 'field' => $field, 'form' => $form]);
                break;
            case "text":
                echo $this->render('field-text', ['model' => $model, 'field' => $field, 'form' => $form]);
                break;
            case "date":
                echo $this->render('field-date', ['model' => $model, 'field' => $field, 'form' => $form]);
                break;
            case "link":
                echo $this->render('field-link', ['model' => $model, 'field' => $field, 'form' => $form]);
                break;
            case "password":
                echo $this->render('field-password', ['model' => $model, 'field' => $field, 'form' => $form]);
                break;
            default:
                echo "";
                break;
        }
    ?>
<?endif;?>
