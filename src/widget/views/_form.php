<?php

use yii\helpers\{ArrayHelper, Html, Json, Url};
use matejch\parcel\models\WebServicePackage;
use yii\widgets\ActiveForm;
use yii\web\View;

$decodedMap = Json::decode($maps[0]->map ?? '');

?>

<?php $shipForm = ActiveForm::begin([
    'action' => $formAction,
    'id' => 'create-parcel-shipment',
    'options'=>['name'=>'parcel-package']]) ?>

<input type="hidden" id="modelID" name="" value="<?= $model->id ?>">

<?php $weight = 0;?>
<?php if($model->hasAttribute('weight')) { ?>
    <input type="hidden" id="modelWeight" value="<?= $model->weight ?>">
    <?php $weight = $model->weight; ?>
<?php } ?>

<label ><?= Yii::t('parcel/msg','map_loading_values')?></label>
<?php if(isset($maps) && !empty($maps)) { ?>
    <?= Html::dropDownList('map',$maps[0]->id ?? '',
        ArrayHelper::map($maps,'id','name'),
        ['class' => 'form-control','id' =>'parcel-map-dropdown','data-url' => Url::to(['parcel/parcel-model-map/get-data','id'=>''])]) ?>
<?php } ?>

<div class="container-flex-new">
    <div class="container-flex-new w-full" style="align-items: center;">
        <label for="PackageCount"><?= Yii::t('parcel/msg','package_count')?></label>
        <div class="py-1">
            <input name="PackageCount" id="PackageCount" value="1" type="number" step="1" min="1"  class="form-control">
        </div>
        <div class="py-1">
            <?= Html::a('<span class="font-bold">&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;</span>',null,['class'=>'btn btn-info packageNumBtn','data-val'=>'1']) ?>
            <?= Html::a('<span class="font-bold">&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;</span>',null,['class'=>'btn btn-warning packageNumBtn','data-val'=>'2']) ?>
            <?= Html::a('<span class="font-bold">&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;</span>',null,['class'=>'btn btn-success packageNumBtn','data-val'=>'3']) ?>
            <?= Html::a('<span class="font-bold">&nbsp;&nbsp;&nbsp;4&nbsp;&nbsp;&nbsp;</span>',null,['class'=>'btn btn-danger packageNumBtn','data-val'=>'4']) ?>
        </div>
    </div>

    <div class="well well-sm w-full container-flex-new" style="padding: 5px;margin-bottom: 5px;" id="packageWrapper"></div>

    <?php foreach ($forms as $form) { ?>
        <div class="well well-sm w-full container-flex-new form-wrapper" style="padding: 5px;margin-bottom: 5px;">

            <!-- FORM HEADER -->
            <?php if($form->getClassName() === 'PickupAddress') { ?>
                <div class="container-flex-new w-full" style="justify-content: space-between;background-color: floralwhite">
                    <h4>
                        <?= $form->name() ?>
                    </h4>
                    <div class="container-flex-new">
                        <div><?= Yii::t('parcel/msg','change_pickup_address') ?>:&nbsp;</div>
                        <div><?= Html::dropDownList('',$pickUpAddressModel->id,ArrayHelper::map($addresses,'id','meno'),
                                ['class' => 'form-control','id' => 'pickup-address-dropdown','data-url' => Url::to(['parcel/pickup-address/get-data','map' => $maps[0]->id ?? ''])])?>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <h4 class="w-full" style="background-color: floralwhite"><?= $form->name() ?></h4>
            <?php }?>
            <!-- FORM HEADER END -->


            <?php foreach ($form->attributeMaps() as $attribute => $value) { ?>
                <div class="w-full max270 px-1">

                    <!-- SETTING CORRECT VALUE FOR ATTRIBUTE -->
                    <?php $valueFromAttr = ''; ?>
                    <?php if(isset($decodedMap[$form->getClassName()][$attribute])) { ?>
                        <?php if($model->hasAttribute($decodedMap[$form->getClassName()][$attribute])) { ?>
                            <?php $valueFromAttr = $model->{$decodedMap[$form->getClassName()][$attribute]}; ?>
                        <?php } else { ?>
                            <?php $valueFromAttr = $decodedMap[$form->getClassName()][$attribute]; ?>
                        <?php } ?>
                    <?php } ?>

                    <?php if($form->getClassName() === 'PickupAddress' && isset($decodedMap[$form->getClassName()][$attribute])) { ?>
                        <?php if($pickUpAddressModel->hasAttribute($decodedMap[$form->getClassName()][$attribute])) { ?>
                            <?php $valueFromAttr = $pickUpAddressModel->{$decodedMap[$form->getClassName()][$attribute]};?>
                        <?php } else { ?>
                            <?php $valueFromAttr = $decodedMap[$form->getClassName()][$attribute];?>
                        <?php } ?>
                    <?php } ?>
                    <!-- SETTING CORRECT VALUE FOR ATTRIBUTE END -->

                    <!-- CHECK FOR USER RBAC RULES -->
                    <?php $inputEnabled = null; ?>
                    <?php if(isset($rbacColumnRules[$form->getClassName()][$attribute])) {
                        if(!Yii::$app->user->can($rbacColumnRules[$form->getClassName()][$attribute])) {
                            $inputEnabled = 'disabled';
                            echo Html::hiddenInput("shipment[".$form->getClassName()."][$attribute]",!empty($valueFromAttr) ? $valueFromAttr : $form->{$attribute});
                        }
                    }?>
                    <!-- CHECK FOR USER RBAC RULES END -->

                    <?php if(!is_array($value)) { ?>
                        <!-- IF IS ARRAY CREATE TEXT INPUT -->
                        <?php if($form->getClassName() === 'WebServicePackage') { ?>

                            <?= $shipForm->field($form,$attribute)->textInput([
                                'name'=>"shipment[".$form->getClassName()."][1][$attribute]",
                                'prompt'=> Yii::t('parcel/msg','prompt'),
                                'value'=>!empty($valueFromAttr) ? $valueFromAttr : $form->{$attribute},
                                'class' => ($attribute === 'reffnr') ? 'map-inputs form-control package-reffnr' : 'map-inputs form-control package-weight',
                                'id' => strtolower($form->getClassName()) ."-$attribute-1",
                                'disabled' => $inputEnabled]) ?>

                        <?php } else { ?>
                            <?= $shipForm->field($form,$attribute)->textInput([
                                'name'=>"shipment[".$form->getClassName()."][$attribute]",
                                'prompt'=> Yii::t('parcel/msg','prompt'),
                                'value'=>!empty($valueFromAttr) ? $valueFromAttr : $form->{$attribute},
                                'class' => 'map-inputs form-control',
                                'disabled' => $inputEnabled]) ?>
                        <?php } ?>
                        <!-- IF IS ARRAY CREATE TEXT INPUT END -->
                    <?php } else { ?>

                        <?php if(isset($value['type']) && $value['type']==='input') { ?>

                            <?php $validation = ['enableClientValidation' => true];$hiddenClass = '';?>
                            <?php if($attribute==='insurvalue' && !$isCod) {
                                $valueFromAttr = 0;
                                $validation = ['enableClientValidation' => false,'options' => ['class' => 'hidden']];
                            } ?>

                            <?php if($form->getClassName() === 'WebServicePackage') { ?>

                                <?php if($attribute == 'weight') { $valueFromAttr = $weight; }?>

                                <?= $shipForm->field($form,$attribute)->textInput([
                                    'name' => "shipment[".$form->getClassName()."][1][$attribute]",
                                    'prompt' => Yii::t('parcel/msg','prompt'),
                                    'value' => !empty($valueFromAttr) ? $valueFromAttr : $form->{$attribute},
                                    'class' => ($attribute === 'reffnr') ? 'map-inputs form-control package-reffnr' : 'map-inputs form-control package-weight',
                                    'id' => strtolower($form->getClassName()) ."-$attribute-1",
                                    'disabled' => $inputEnabled,'type' => 'number','min'=>0,'step' => '0.001']) ?>

                            <?php } else { ?>
                                <?php if($attribute === 'insurvalue' || $attribute === 'codvalue') { $valueFromAttr = $price; } ?>

                                <?= $shipForm->field($form,$attribute,$validation)
                                    ->textInput([
                                        'name'=>"shipment[".$form->getClassName()."][$attribute]",
                                        'prompt'=>Yii::t('parcel/msg','prompt'),
                                        'value'=> !empty($valueFromAttr) ? $valueFromAttr : $form->{$attribute},
                                        'class' => 'map-inputs form-control',
                                        'disabled' => $inputEnabled])
                                    ->label($value['label']) ?>

                            <?php } ?>

                        <?php } else { ?>

                            <?php $valueFromAttr = !empty($valueFromAttr) ? $valueFromAttr : $form->{$attribute} ?>

                            <?php if($isSaturday && $attribute === 'saturdayshipment') {$valueFromAttr = 1;} ?>

                            <?php if($isCzech && $attribute === 'country_del') {$valueFromAttr = 'CZ';} ?>

                            <?php if(empty($valueFromAttr) && $attribute === 'webServiceShipmentType') {$valueFromAttr = 0;} ?>
                            <?= $shipForm->field($form,$attribute)
                                ->dropDownList($value['values'],[
                                    'name'=>"shipment[".$form->getClassName()."][$attribute]",
                                    'prompt'=>Yii::t('parcel/msg','prompt'),
                                    'value' => $valueFromAttr,
                                    'class' => 'map-inputs form-control',
                                    'disabled' => $inputEnabled])
                                ->label($value['label']) ?>

                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<div class="container-flex-new" style="justify-content: space-between">
    <?= Html::submitButton(Yii::t('parcel/msg','send_btn',['name' => $account->name]),['class'=>'btn btn-success','id' =>'send-to-parcel']) ?>
    <span id="send-to-parcel-msg"></span>

    <div class="container-flex-new">
        <div><?= Yii::t('parcel/msg','change_account')?>:&nbsp;</div>
        <div>
            <?= Html::dropDownList('accountId','',ArrayHelper::map($accounts,'id','name'),['class' => 'form-control', 'id' => 'account-dropdown']) ?>
        </div>
    </div>
</div>


<?php ActiveForm::end() ?>


<?php

$btnMsg = Yii::t('parcel/msg','send_btn',['name' => '']);

$parcelCreateScript = <<< JS

document.querySelector('body #modalGlobal #send-to-parcel').addEventListener('mouseover', (e) => {
    let weight = 0;
    document.querySelectorAll('body #modalGlobal .package-weight').forEach(function(element) {
         weight += parseFloat(element.value);
    });
    
    if(weight != parseFloat('$weight')) {
        e.target.setAttribute('disabled','disabled');
        document.getElementById('send-to-parcel-msg').innerText = 'Váha balíkov ' + weight + ' sa nezhoduje z váhou objednávky '+'$weight';
    } else {
       e.target.removeAttribute('disabled');
       document.getElementById('send-to-parcel-msg').innerText = '';
    }
});

document.getElementById('parcel-map-dropdown').addEventListener('change', e => {
    let url = e.target.dataset.url + e.target.value + 
    '&address=' + document.getElementById('pickup-address-dropdown').value + 
    '&modelID='+document.getElementById('modelID').value;
    
    fetch(url)
    .then(res => res.json())
    .then(data => {
         if(data['success'] === true) {
             document.querySelectorAll('.map-inputs').forEach(function(element) {
                 element.value = '';
             });
             
             for(const key of Object.keys(data['values'])) {
                 if(key === 'webservicepackage-reffnr') {
                     document.querySelectorAll('.package-reffnr').forEach(function(el) {
                       el.value =  data['values'][key];
                     });
                 } else if(key === 'webservicepackage-weight') {
                     document.querySelectorAll('.package-weight').forEach(function(el) {
                       el.value =  data['values'][key];
                     });
                 } else {
                    if(document.getElementById(key)) {
                        document.getElementById(key).value = data['values'][key];
                    } 
                 }
             }
             
             
         }
    })
    .catch(err => console.error('Error: ' + err));
});

document.getElementById('pickup-address-dropdown').addEventListener('change', e=> {
    let url = e.target.dataset.url + '&address=' + e.target.value;
    fetch(url).then(res => res.json()).then(data => {
        if(data['success'] === true) {
            for (let key of Object.keys(data['values'])) {
                if(document.getElementById("pickupaddress-"+key)) {
                    document.getElementById("pickupaddress-"+key).value = '';
                    document.getElementById("pickupaddress-"+key).value = data['values'][key];
                }
            }
        }
        
    }).catch(err => console.error('Error: ' + err));
});

document.getElementById('account-dropdown').addEventListener('change', e => {
    
    document.querySelector('#create-parcel-shipment #send-to-parcel').innerText = "$btnMsg " +e.target.options[e.target.selectedIndex].text;
});

document.getElementById('PackageCount').addEventListener('change', e => {
    let value = parseInt(e.target.value);
    
    const divNode = document.getElementById("packageWrapper");
    while (divNode.firstChild) {
        divNode.removeChild(divNode.firstChild);
    }
    
    createPackages(value);
});

document.querySelectorAll('.packageNumBtn').forEach(function(element, index) {
    element.addEventListener('click',(e) => {
        e.preventDefault();
        let value = parseInt(e.target.getAttribute('data-val'));
        document.getElementById('PackageCount').value = value;
        
        const divNode = document.getElementById("packageWrapper");
        while (divNode.firstChild) {
            divNode.removeChild(divNode.firstChild);
        }
        
        createPackages(value);
    });
});

function createPackages(numOfPackages) {
  for (let i=2; i <= numOfPackages; i++) {
      let tmpl = document.getElementById('package-form-template').content.cloneNode(true);
            
      let reffNrEl = tmpl.getElementById('webservicepackage-reffnr');
      let reffNrWrapperEl = tmpl.querySelector('.field-webservicepackage-reffnr');
      
      let weightEl = tmpl.getElementById('webservicepackage-weight');
      let weightWrapperEl =  tmpl.querySelector('.field-webservicepackage-weight');
      
      reffNrEl.value = document.querySelector('.form-wrapper #webservicepackage-reffnr-1').value;
      reffNrEl.setAttribute('name','shipment[WebServicePackage][' + i + '][reffnr]');
      reffNrEl.id = 'webservicepackage-reffnr-' + i;
      reffNrWrapperEl.classList.remove('field-webservicepackage-reffnr');
      reffNrWrapperEl.classList.add('field-webservicepackage-reffnr-' + i);
      
      weightEl.setAttribute('name','shipment[WebServicePackage][' + i + '][weight]');
      weightEl.id='webservicepackage-weight-' + i;
      weightWrapperEl.classList.remove('field-webservicepackage-weight');
      weightWrapperEl.classList.add('field-webservicepackage-weight-' + i);
            
      document.getElementById('packageWrapper').append(tmpl);
      
      $('#create-parcel-shipment').yiiActiveForm('add', {
        id: 'webservicepackage-reffnr-' + i,
        name: 'shipment[WebServicePackage][' + i + '][reffnr]',
        container: '.field-webservicepackage-reffnr-' + i,
        input: '#webservicepackage-reffnr-' + i,
        error: '.help-block',
        validate:  function (attribute, value, messages, deferred, form) {
           yii.validation.required(value, messages, {message: "Pole Referenčné číslo balíka nesmie byť prázdne."});
        }
    });
    
    $('#create-parcel-shipment').yiiActiveForm('add', {
        id: 'webservicepackage-weight-' + i,
        name: 'shipment[WebServicePackage][' + i + '][weight]',
        container: '.field-webservicepackage-weight-' + i,
        input: '#webservicepackage-weight-' + i,
        error: '.help-block',
        validate:  function (attribute, value, messages, deferred, form) {
           yii.validation.required(value, messages, {message: "Pole Váha balíka (KG) nesmie byť prázdne."});
        }
    });
  }
}

document.querySelector('body').addEventListener('click',function (e) {
    if(e.target.classList.contains('remove-package')) {
        e.preventDefault();
        document.getElementById('PackageCount').value -= 1;
        
        e.target.closest('.well').querySelectorAll('input').forEach(function(element) {
            $('#create-parcel-shipment').yiiActiveForm('remove', element.id);
        });
        
        e.target.closest('.well').remove();
    }
});

JS;

$this->registerJs($parcelCreateScript,View::POS_READY,'parcelCreateScript');
?>

<template id="package-form-template">
    <?php $package = new WebServicePackage(); ?>
    <div class="well well-sm w-full container-flex-new" style="padding: 5px;margin-bottom: 5px;">
        <div class="container-flex-new w-full" style="background-color: floralwhite;justify-content: space-between">
            <h4><?= $package->name() ?></h4>
            <?= Html::a('<i class="fas fa-times"></i>','#',['class' => 'btn btn-default remove-package','style' => 'color:darkred']) ?>
        </div>

        <div class="w-full max270 px-1">
            <div class="form-group field-webservicepackage-reffnr required">
                <label class="control-label"><?= $package->getAttributeLabel('reffnr') ?></label>
                <input type="text" class="map-inputs form-control package-reffnr" value="" name="shipment[WebServicePackage][reffnr]" id="webservicepackage-reffnr" aria-required="true">
                <div class="help-block"></div>
            </div>
        </div>
        <div class="w-full max270 px-1">
            <div class="form-group field-webservicepackage-weight required">
                <label class="control-label"><?= $package->getAttributeLabel('weight') ?></label>
                <input type="text" class="map-inputs form-control package-weight" value="" name="shipment[WebServicePackage][weight]" id="webservicepackage-weight" aria-required="true">
                <div class="help-block"></div>
            </div>
        </div>
    </div>
</template>
