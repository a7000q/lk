<?
use kartik\tabs\TabsX;
?>

<?
    foreach ($model::$tableBD->tableLinks as $link)
        $items[] = [
            'label' => $link->tableRef->rus_name,
            'content' => $this->render('table', ['link' => $link, 'model' => $model])
        ];
?>

<?=TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_ABOVE,
    'encodeLabels'=>false
]);
?>
