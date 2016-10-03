<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class EditablePageAsset extends AssetBundle
{
    public $sourcePath = '@vendor/kartik-v';

    public $css = [
        'yii2-editable/assets/css/editable.min.css',
        'yii2-widget-select2/assets/css/select2.min.css',
        'yii2-widget-select2/assets/css/select2-addl.min.css',
        'yii2-widget-select2/assets/css/select2-krajee.min.css',
        'yii2-grid/assets/css/kv-grid-action.min.css',
        'bootstrap-popover-x/css/bootstrap-popover-x.min.css',
    ];


}
