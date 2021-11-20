<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \matejch\parcel\models\ParcelModelMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parcel-model-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(Yii::$app->request->get('m')) { $model->model = Yii::$app->request->get('m'); } ?>

    <?php if(Yii::$app->request->get('m')) { $model->function = Yii::$app->request->get('f'); } ?>

    <?php $disabled = false;?>
    <?php if (!$model->isNewRecord) { $disabled = true; } ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->dropDownList($models,['disabled' => $disabled]) ?>

    <?= $form->field($model, 'function')->dropDownList($functions,['disabled' => $disabled]) ?>

    <?= $this->render('_attributes',['form' => $form,'model' => $model,'pickUpAddress' => $pickUpAddress,]) ?>

    <div class="px-1 py-1">
        <?= Html::submitButton(Parcel::t('msg', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$parcelModelMapForm = <<< JS
document.querySelector('body').addEventListener('change', e => {
    if(e.target.id === 'parcelmodelmap-model') {
        let url = new URL(window.location.href);
        let searchParams = new URLSearchParams(url.search);
        searchParams.set('m', e.target.value);
        url.search = searchParams.toString();
        window.location.href = url.toString();
    } else if(e.target.id === 'parcelmodelmap-function') {
        let url = new URL(window.location.href);
        let searchParams = new URLSearchParams(url.search);
        searchParams.set('f', e.target.value);
        url.search = searchParams.toString();
        window.location.href = url.toString();
    }
});
JS;

$this->registerJs($parcelModelMapForm,View::POS_READY,'parcelModelMapForm');