<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class GlobalThemeAsset extends AssetBundle
{
    public $sourcePath = '@common/web/assets';

    public $css = [
        'global/css/components.min.css',
        'global/css/plugins.min.css'
    ];

    public $js = [
        'global/scripts/app.min.js'
    ];


    public $depends = [
        'common\assets\GlobalMandatoryAsset'
    ];
}
