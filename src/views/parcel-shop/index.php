<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parcel\models\ParcelShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Parcel::t('msg', 'solver_alt_places');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solver-alt-place-index mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('../templates/_navbar') ?>

    <p>
        <?= Html::a(Parcel::t('msg','populate_records'), ['parcel-shop/populate-records'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url , $model) { return  Html::a('<i class="fas fa-eye"></i>',$url);},
                ]
            ],
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
            'workDays' =>[
                'attribute' => 'workDays',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->getWorkDays();
                }
            ],
        ],
    ]); ?>
</div>
