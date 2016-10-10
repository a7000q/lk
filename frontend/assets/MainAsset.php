<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class MainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css'
    ];

    public $depends = [
        'frontend\assets\LayoutAsset'
    ];

}
