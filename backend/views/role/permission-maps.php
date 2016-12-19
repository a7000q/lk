<?
use kartik\tabs\TabsX;
use yii\helpers\Url;
use backend\models\maps\PermissionMaps;
?>

<?
    $maps = PermissionMaps::find()->where(['<>', 'name', ''])->all();
    $items = array();
    foreach ($maps as $map)
    {
        $map->role_name = $model->name;
        $items[] = [
            'label' => $map->name,
            'content' => $this->render('permission-map-point', ['map' => $map])
        ];
    }
?>

<?=TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_LEFT,
    'encodeLabels'=>false
]);
?>
