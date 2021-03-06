<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Parcel::t('msg', 'Parcel accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solver-api-index mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('../templates/_navbar') ?>

    <p>
        <?= Html::a($this->render('../icons/_plus') . ' ' . Parcel::t('msg', 'create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a($this->render('../icons/_eye'), $url);
                    },
                    'update' => function ($url, $model) {
                        return Html::a($this->render('../icons/_pencil'), $url);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a($this->render('../icons/_trash'), $url, ['data' => ['method' => 'post',
                            'confirm' => Parcel::t('msg', 'delete_msg')]]);
                    },
                ]
            ],
            'name',
            'username:ntext',
            'password' => [
                'attribute' => 'password',
                'format' => 'text',
                'value' => static function ($model) {
                    return '******';
                },
            ],
            'default' => [
                'attribute' => 'default',
                'format' => 'raw',
                'value' => static function ($model) {
                    if ($model->default) {
                        return Parcel::t('model', 'default');
                    }

                    return Html::a(Parcel::t('msg', 'set_default'),
                        ['update', 'id' => $model->id],
                        ['class' => 'btn btn-default btn-light', 'data' => ['method' => 'post', 'params' =>
                            [
                                'ParcelAccount[default]' => 1
                            ]
                        ]
                        ]);
                },
            ],
        ],
    ]) ?>
</div>
