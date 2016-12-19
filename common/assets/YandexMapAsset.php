<?php

namespace common\assets;

use yii\base\View;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class YandexMapAsset extends AssetBundle
{
    public $sourcePath = '@common/web/assets';

    public $js = [
        'https://api-maps.yandex.ru/2.1/?lang=ru_RU'
    ];

    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
}
