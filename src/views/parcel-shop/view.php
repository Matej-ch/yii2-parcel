<?php

use matejch\parcel\Parcel;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model \matejch\parcel\models\ParcelShop */

$this->title = $model->place_id;
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'solver_alt_places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solver-alt-place-view mt-20 w-full px-4">

    <?= $this->render('@app/views/templates/_title', ['title' => $this->title]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'type',
            'place_id',
            'description:ntext',
            'address',
            'city',
            'zip',
            'virtualzip',
            'countryISO',
            'status',
            'gps:ntext',
            'center',
            'workDays' => [
                'attribute' => 'workDays',
                'format' => 'raw',
                'value' => $model->getWorkDays(),

            ],
        ],
    ]) ?>

</div>
