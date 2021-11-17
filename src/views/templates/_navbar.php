<?php

use matejch\parcel\Parcel;
use yii\helpers\Html; ?>

<div class="text-center w-full">
    <?= Html::a(Parcel::t('msg','Parcel accounts'), ['parcel-account/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Parcel::t('msg','solver_alt_places'), ['parcel-shop/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Parcel::t('msg','parcel_shipments'), ['parcel-shipment/index'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Parcel::t('msg','Parcel Model Maps'), ['parcel-model-map/index'], ['class' => 'btn btn-primary']) ?>
</div>

