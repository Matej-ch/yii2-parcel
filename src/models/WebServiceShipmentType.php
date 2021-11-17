<?php


namespace matejch\parcel\models;

use matejch\parcel\Parcel;

/**
 * @property int $webServiceShipmentType
*/
class WebServiceShipmentType extends ServiceBase
{
    public $webServiceShipmentType;

    public function rules()
    {
        return [
            [['webServiceShipmentType'], 'required'],
            [['webServiceShipmentType'],'default','value'=>0],
            [['webServiceShipmentType'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'webServiceShipmentType' => Parcel::t('model','webServiceShipmentType'),
        ];
    }

    public function attributeMaps()
    {
        return [
            'webServiceShipmentType' => [
                'label' => Parcel::t('model','webServiceShipmentType'),
                'values' => [
                    0 => Parcel::t('model','print_labels'),
                    1 => Parcel::t('model','order_shipment')
                ],
            ]
        ];
    }

    public function name()
    {
        return Parcel::t('model','webServiceShipmentType');
    }

    public function isPickUpAddress()
    {
        return false;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}