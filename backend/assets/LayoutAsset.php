<?php

namespace backend\assets;

use yii\web\AssetBundle;

class LayoutAsset extends AssetBundle
{
    public $sourcePath = '@common/web/assets';
    public $css = [
        'layouts/layout2/css/layout.min.css',
        'layouts/layout2/css/themes/blue.min.css',
        'layouts/layout2/css/custom.min.css'
    ];
    public $js = [
        'layouts/layout2/scripts/layout.min.js',
        'layouts/layout2/scripts/demo.min.js',
        'layouts/global/scripts/quick-sidebar.min.js',
        'layouts/global/scripts/quick-nav.min.js'
    ];

    public $depends = [
        'common\assets\GlobalThemeAsset',
        'backend\assets\MainAsset'
    ];

}
