<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class LayoutAsset extends AssetBundle
{
    public $sourcePath = '@common/web/assets';
    public $css = [
        'layouts/layout/css/layout.min.css',
        'layouts/layout/css/themes/darkblue.min.css',
        'layouts/layout/css/custom.min.css'
    ];
    public $js = [
        'layouts/layout/scripts/layout.min.js',
        'layouts/layout/scripts/demo.min.js',
        'layouts/global/scripts/quick-sidebar.min.js',
    ];

    public $depends = [
        'common\assets\GlobalThemeAsset'
    ];

}
