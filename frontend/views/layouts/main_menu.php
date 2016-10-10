<?
use kartik\sidenav\SideNav;
?>

<?
echo SideNav::widget([
    'items' => $items,
    'containerOptions' => [
        'style' => 'padding-top: 60px;'
    ],
    'itemOptions' => [
        'class' => 'nav-item'
    ]
]);
?>