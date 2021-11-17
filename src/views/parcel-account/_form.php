<?php

use matejch\parcel\Parcel;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parcel\models\ParcelAccount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solver-api-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'default')
        ->dropDownList([1 => Parcel::t('msg','yes'),0 =>  Parcel::t('msg','no')])
        ->label(Parcel::t('msg','set_default')) ?>

    <div class="px-1 py-1">
        <?= Html::submitButton(Parcel::t('msg', 'save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
