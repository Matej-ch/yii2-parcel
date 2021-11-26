<?php

namespace matejch\parcel\assets;

use yii\web\AssetBundle;
use yii\web\View;

class ParcelFormAsset extends AssetBundle
{
    public $sourcePath = '@matejch/parcel/web';

    public $css = [];

    public $js = [
        'js/parcelForm.min.js',
    ];

    /*public $jsOptions = [
        'position' => View::POS_HEAD,
    ];*/

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}