<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;

/**
 * @property string $pickupstartdatetime
 * @property string $pickupenddatetime
 */
class ShipmentPickup extends ServiceBase
{
    public $pickupstartdatetime;
    public $pickupenddatetime;

    public function rules()
    {
        return [
            [['pickupstartdatetime','pickupenddatetime'], 'required'],
            [['pickupstartdatetime','pickupenddatetime'], 'datetime','format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'pickupstartdatetime' => Parcel::t('model','pickupstartdatetime'),
            'pickupenddatetime' => Parcel::t('model','pickupenddatetime'),
        ];
    }

    public function attributeMaps()
    {
        return $this->attributeLabels();
    }
}