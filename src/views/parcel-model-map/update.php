<?php


/* @var $this yii\web\View */
/* @var $model \matejch\parcel\models\ParcelModelMap */

use matejch\parcel\Parcel;

$this->title = Parcel::t('msg', 'update');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel Model Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Parcel::t('msg', 'update');

 ?>
<div class="parcel-model-map-update mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $models,
        'functions' => $functions,
        'pickUpAddress' => $pickUpAddress,
    ]) ?>

</div>
