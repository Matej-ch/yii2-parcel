<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\parcel\models\ParcelShipment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'parcel_shipments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-shipment-view mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <p>
        <?= Html::a('<i class="fas fa-trash" aria-hidden="true"></i> ' . Parcel::t('msg','delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Parcel::t('msg','delete_msg'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'function',
            'model',
            'data:ntext',
            'response' => [
                'attribute' => 'response',
                'format' => 'raw',
                'value' => $model->getParsedResponse()
            ],
        ],
    ]) ?>

</div>
