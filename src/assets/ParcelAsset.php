<?php

namespace matejch\parcel\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ParcelAsset extends AssetBundle
{
    public $sourcePath = '@matejch/parcel/web';

    public $css = [
        'css/parcel.min.css',
    ];

    public $jsOptions = [
        'position' => View::POS_READY,
    ];

    public $js = [];

    public $publishOptions = [
        'only' => [
            'css/*',
            'js/*',
        ]
    ];

    public $depends = [];
}