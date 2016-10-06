<?
use kartik\tabs\TabsX;
use backend\models\tables\PermissionTables;
use yii\helpers\Url;
?>

<?
    $tables = PermissionTables::find()->all();
    $items = array();
    foreach ($tables as $table)
    {
        $table->role_name = $model->name;
        $items[] = [
            'label' => $table->rus_name,
            'content' => $this->render('table-permission', ['table' => $table])
        ];
    }
?>

<?=TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_LEFT,
    'encodeLabels'=>false
]);
?>
