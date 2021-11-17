<?php

/* @var $this yii\web\View */
/* @var $model app\modules\parcel\models\ParcelModelMap */

use matejch\parcel\Parcel;

$this->title = Parcel::t('msg', 'create');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel Model Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="parcel-model-map-create mt-20 w-full px-4">

    <?= $this->render('@app/views/templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $models,
        'functions' => $functions,
        'pickUpAddress' => $pickUpAddress,
    ]) ?>

</div>
