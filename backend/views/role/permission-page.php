<?
use kartik\tabs\TabsX;
use yii\helpers\Url;
use backend\models\pages\PermissionPages;
?>

<?
    $pages = PermissionPages::find()->where(['<>', 'name', ''])->all();
    $items = array();
    foreach ($pages as $page)
    {
        $page->role_name = $model->name;
        $items[] = [
            'label' => $page->name,
            'content' => $this->render('permission-page-detail', ['page' => $page])
        ];
    }
?>

<?=TabsX::widget([
    'items'=>$items,
    'position'=>TabsX::POS_LEFT,
    'encodeLabels'=>false
]);
?>
