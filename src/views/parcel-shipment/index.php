<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Parcel::t('msg', 'parcel_shipments');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['parcel-account/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parcel-shipment-index mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('../templates/_navbar') ?>

    <p style="display: flex;align-items:baseline;">
        <?= Html::a(Parcel::t('msg','printEndOfDay'), ['cif-shipment/print-day'], ['class' => 'btn btn-success','title' => Parcel::t('msg','printEndOfDay_hint')]) ?>
        <label for="menuToggle" class="toggleButton md-button md-button--raised" style="margin-left: 1em">?</label>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'view' => function($url , $model) { return  Html::a($this->render('../icons/_eye'),$url);},
                    'delete' => function($url , $model) { return Html::a($this->render('../icons/_trash'),$url,['data' => ['method' => 'post',
                        'confirm' => Parcel::t('msg','delete_msg'),]]);},
                ]
            ],
            'id',
            'function',
            'model',
            'model_id' => [
                'attribute' =>'model_id',
                'format' => 'raw',
                'value' => static function($model){
                    return Html::a($model->model_id,['order/view','id'=>$model->model_id]);
                },
                'contentOptions' => ['data-th'=>$searchModel->getAttributeLabel('model_id')],
                'filterOptions' => ['data-th'=>$searchModel->getAttributeLabel('model_id')],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'raw',
                'value' => static function($model) {
                    return Yii::$app->formatter->asDate($model->created_at,"dd.MM.yyyy");
                },

                'contentOptions' => ['data-th'=>$searchModel->getAttributeLabel('created_at')],
                'filterOptions' => ['data-th'=>$searchModel->getAttributeLabel('created_at')],
            ],
            'data:ntext',
            'response' => [
                'attribute' => 'response',
                'format' => 'raw',
                'value' => static function ($model) {
                    return $model->parsedResponse;
                }
            ],
            'is_active' => [
                'attribute' => 'is_active',
                'contentOptions' => ['data-th'=>$searchModel->getAttributeLabel('is_active')],
                'filterOptions' => ['data-th'=>$searchModel->getAttributeLabel('is_active')],
                'format' => 'raw',
                'value' => static function($model) {
                    return $model->is_active === 1 ? Parcel::t('model','valid') : Parcel::t('model','invalid');
                },
                'filter' => Html::activeDropDownList($searchModel,'is_active',[0=>'Neplatný',1=>'Platný'],['class'=>'form-control','prompt'=>Parcel::t('model','prompt')])
            ]
        ],
    ]) ?>
</div>

<div>
    <input id="menuToggle" type="checkbox">
    <div class="infobox md-card">
        <div class="md-card-content">
            <?= Parcel::t('msg','printEndOfDay_info') ?>
        </div>
        <div class="md-card-btns">
            <label for="menuToggle" class="md-button"><?= Parcel::t('msg','close') ?></label>
        </div>
    </div>
</div>