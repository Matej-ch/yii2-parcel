<?php

/* @var $this yii\web\View */
/* @var $model app\modules\parcel\models\ParcelAccount */

use matejch\parcel\Parcel;

$this->title = Parcel::t('msg', 'update');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Parcel::t('msg', 'update');

 ?>
<div class="solver-api-update mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
