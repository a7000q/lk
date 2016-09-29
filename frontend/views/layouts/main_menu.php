<?
use yii\widgets\Menu;
?>

<?
echo Menu::widget([
    'items' => $items,
    'options' => [
        'class' => 'page-sidebar-menu  page-header-fixed',
        'data-keep-expanded' => 'false',
        'data-auto-scroll' => 'true',
        'data-slide-speed' => 200,
        'style' => 'padding-top: 50px'
    ],
    'itemOptions' => [
        'class' => 'nav-item'
    ],
    'linkTemplate' => '<a href="{url}" class="nav-link nav-toggle"><span class="title">{label}</span></a>',
    'encodeLabels' => false,
    'firstItemCssClass'=>'sidebar-toggler-wrapper hide',
]);
?>