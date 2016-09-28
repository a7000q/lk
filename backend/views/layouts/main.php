<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use backend\assets\LayoutAsset;
LayoutAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<?php $this->beginBody() ?>
<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
            <a href="/">
                <?=Html::img('@commonWeb/assets/layouts/layout/img/miniLogo.png', ['alt' => 'logo', 'class' => 'logo-default'])?>
            </a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="page-top">
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">

                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="<?=Yii::getAlias('@commonWeb')?>/assets/layouts/layout/img/avatar3_small.jpg" />
                            <span class="username username-hide-on-mobile"> <?=Yii::$app->user->identity->username?>  </span>
                        </a>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-extended">
                        <a href="<?=Url::toRoute('site/logout')?>" class="dropdown-toggle" data-method="post">
                            <i class="icon-logout"></i>
                        </a>
                    </li>
                    <!-- END QUICK SIDEBAR TOGGLER -->
                </ul>
            </div>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
<!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"> </div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar navbar-collapse collapse">
            <!-- BEGIN SIDEBAR MENU -->
            <?
                echo Menu::widget([
                    'items' => [
                        [
                            'label' => '<i class="icon-briefcase"></i><span class="title">Таблицы</span><span class="arrow"></span>',
                            'url' => ['table/index']
                        ],
                    ],
                    'options' => [
                        'class' => 'page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu',
                        'data-keep-expanded' => 'false',
                        'data-auto-scroll' => 'true',
                        'data-slide-speed' => 200
                    ],
                    'itemOptions' => [
                        'class' => 'nav-item'
                    ],
                    'linkTemplate' => '<a href="{url}" class="nav-link ">{label}</a>',
                    'encodeLabels' => false,
                ]);
            ?>
            <!-- END SIDEBAR MENU -->
            <!-- END SIDEBAR MENU -->
        </div>
        <!-- END SIDEBAR -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?=$content;?>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->

<!--[if lt IE 9]>
<script src="<?=Yii::getAlias('@commonWeb')?>/assets/global/plugins/respond.min.js"></script>
<script src="<?=Yii::getAlias('@commonWeb')?>/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<?php $this->endBody() ?>
<script>
    jQuery.noConflict( true );
</script>
</body>
</html>
<?php $this->endPage() ?>
