<?php

use matejch\parcel\Parcel;
use yii\helpers\Json;

/* @var $form yii\widgets\ActiveForm */
/* @var $model \matejch\parcel\models\ParcelModelMap */

$selectedModel = Yii::$app->request->get('m');
$order = new $selectedModel();

if(Yii::$app->request->get('f') === 'createCifShipment') {
    $map = $model::cifShipmentMap('map');
} else {
    $map = $model::mipShipmentMap('map');
}

if(!$model->isNewRecord) {
    $existingMap = Json::decode($model->map);
}

?>

<h4><?= $model->getAttributeLabel('map') ?></h4>

<div class="container-flex-new">
    <?php foreach ($map as $class) { ?>
        <div class="well well-sm w-full container-flex-new">
            <h2 class="w-full"><?= $class->name() ?></h2>
            <?php foreach ($class->attributeMaps() as $attribute => $value) { ?>
                <div class="w-full max300 py-1 px-1">
                    <?php if(!is_array($value)) { ?>
                        <?= $form->field($class,$attribute)
                            ->dropDownList($class->isPickUpAddress() ? $pickUpAddress->attributeLabels() : $order->attributeLabels(),
                                ['name'=>"ParcelModelMap[map][".$class->getClassName()."][$attribute]",'prompt'=>Parcel::t('msg','prompt'),'value'=>$existingMap[$class->getClassName()][$attribute] ?? ''])
                        ?>
                    <?php } else { ?>
                        <?php if(isset($value['type']) && $value['type']==='input') { ?>
                            <?= $form->field($class,$attribute)
                                ->textInput(['name'=>"ParcelModelMap[map][".$class->getClassName()."][$attribute]",'prompt'=>Parcel::t('msg','prompt'),'value'=> $existingMap[$class->getClassName()][$attribute] ?? ''])
                                ->label($value['label']) ?>
                        <?php } else { ?>
                            <?= $form->field($class,$attribute)
                                ->dropDownList($value['values'],['name'=>"ParcelModelMap[map][".$class->getClassName()."][$attribute]",'prompt'=>Parcel::t('msg','prompt'),'value'=>$existingMap[$class->getClassName()][$attribute] ?? ''])
                                ->label($value['label']) ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
