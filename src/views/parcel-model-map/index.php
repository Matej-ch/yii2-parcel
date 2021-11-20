<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Parcel::t('msg', 'Parcel Model Maps');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-model-map-index mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('../templates/_navbar') ?>

    <p>
        <?= Html::a('<i class="fas fa-plus" aria-hidden="true"></i> ' . Parcel::t('msg', 'create'),
            ['create', 'm' => Parcel::getInstance()->models[0], 'f' => 'createCifShipment'],
            ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => static function ($url, $model) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', ['update', 'id' => $model->id, 'm' => $model->model, 'f' => $model->function]);
                    },
                    'delete' => static function ($url, $model) {
                        return Html::a('<i class="fas fa-trash"></i>', $url, ['data' => ['method' => 'post',
                            'confirm' => 'Are you sure you want to delete this item?',]]);
                    },
                ]
            ],
            'id',
            'name',
            'function',
            'model',
            'map' => [
                'attribute' => 'map',
                'contentOptions' => ['style' => 'word-break: break-all;']
            ],
            'default' => [
                'attribute' => 'default',
                'format' => 'raw',
                'value' => static function ($model) {
                    if ($model->default) {
                        return Parcel::t('model', 'default_map');
                    }

                    return Html::a(Parcel::t('msg', 'set_default'),
                        ['set-default', 'id' => $model->id],
                        ['class' => 'btn btn-default', 'data' => ['method' => 'post', 'params' =>
                            [
                                'ParcelModelMap[default]' => 1
                            ]
                        ]
                        ]);
                },
            ],
        ],
    ]); ?>
</div>
