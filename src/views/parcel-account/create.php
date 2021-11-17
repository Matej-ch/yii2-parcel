<?php


/* @var $this yii\web\View */
/* @var $model app\modules\parcel\models\ParcelAccount */

use matejch\parcel\Parcel;

$this->title = Parcel::t('msg', 'Create parcel account');
$this->params['breadcrumbs'][] = ['label' => Parcel::t('msg', 'Parcel accounts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

 ?>
<div class="solver-api-create mt-20 w-full px-4">

    <?= $this->render('../templates/_title', ['title' => $this->title]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
