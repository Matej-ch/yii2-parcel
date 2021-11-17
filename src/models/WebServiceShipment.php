<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;

/**
 * @property Cod|null $cod
 * @property string $insurvalue
 * @property string|null $notifytype
 * @property string $productdesc
 * @property boolean|null $recipientpay
 * @property boolean|null $returnshipment
 * @property boolean|null $saturdayshipment
 * @property string|null $servicename
 * @property boolean|null $tel
 * @property string $units
 * @property WebServicePackage[] $packages
 * @property PickupAddress|null $pickupaddress
 * @property DeliveryAddress $deliveryaddress
 * @property ShipmentPickup|null $shipmentpickup
 * @property integer|null $codattribute
 * @property string|null $deliverytype
 */
class WebServiceShipment extends ServiceBase
{
    public $cod;
    public $insurvalue;
    public $notifytype;
    public $productdesc;
    public $recipientpay;
    public $returnshipment;
    public $saturdayshipment;
    public $servicename;
    public $tel;
    public $units;
    public $packages;
    public $pickupaddress;
    public $deliveryaddress;
    public $shipmentpickup;
    public $codattribute;
    public $deliverytype;

    public function rules()
    {
        return [
            [['insurvalue','units'], 'required'],
            [['packages','deliveryaddress','pickupaddress','cod','shipmentpickup'],'safe'],
            [['insurvalue'],'string'],
            [['notifytype'],'default','value'=>0],
            [['notifytype'],'in','range' => range(0,3)],
            [['productdesc'],'string','max'=>150],
            [['recipientpay','returnshipment','saturdayshipment','tel'],'boolean'],
            [['deliverytype'],'string','max' => 5],
            [['codattribute'],'integer'],
            [['codattribute'],'default','value'=>0],
            [['deliverytype'],'in','range' => ['2PT','2PS']],
            [['units','servicename'],'string','max'=>50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cod' => Parcel::t('model','cod'),
            'insurvalue' => Parcel::t('model','insurvalue'),
            'notifytype' => Parcel::t('model','notifytype'),
            'productdesc' => Parcel::t('model','productdesc'),
            'recipientpay' => Parcel::t('model','recipientpay'),
            'returnshipment' => Parcel::t('model','returnshipment'),
            'saturdayshipment' => Parcel::t('model','saturdayshipment'),
            'servicename' => Parcel::t('model','servicename'),
            'tel' => Parcel::t('model','tel'),
            'units' => Parcel::t('model','units'),
            'packages' => Parcel::t('model','packages'),
            'pickupaddress' => Parcel::t('model','pickupaddress'),
            'deliveryaddress' => Parcel::t('model','deliveryaddress'),
            'shipmentpickup' => Parcel::t('model','shipmentpickup'),
            'codattribute' => Parcel::t('model','codattribute'),
            'deliverytype' => Parcel::t('model','deliverytype'),
        ];
    }

    public function attributeHints()
    {
        return [
            'notifytype' => Parcel::t('model','notifytype_hint'),
            'servicename' => Parcel::t('model','servicename_hint'),
            'units' => Parcel::t('model','units_hint'),
            'pickupaddress' => Parcel::t('model','pickupaddress_hint'),
            'codattribute' => Parcel::t('model','codattribute_hint'),
            'deliverytype' => Parcel::t('model','deliverytype_hint'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['map'] = ['units'];
        return $scenarios;
    }

    public function attributeMaps()
    {
        return [
            'insurvalue' => [
                'label' => Parcel::t('model','insurvalue'),
                'type' => 'input'
            ],
            'notifytype' => [
                'label' => Parcel::t('model','notifytype'),
                'values' => [
                    0 => Parcel::t('model','disabled'),
                    1 => Parcel::t('model','email'),
                    2 => Parcel::t('model','sms'),
                    3 => Parcel::t('model','both email and sms')
                ]
            ],
            'productdesc' => Parcel::t('model','productdesc'),
            'recipientpay' => [
                'label' => Parcel::t('model','recipientpay'),
                'values' => [
                    0 => Parcel::t('model','no'),
                    1 => Parcel::t('model','yes'),
                ]
            ],
            'returnshipment' => [
                'label' => Parcel::t('model','returnshipment'),
                'values' => [
                    0 => Parcel::t('model','no'),
                    1 => Parcel::t('model','yes'),
                ]
            ],
            'saturdayshipment' => [
                'label' => Parcel::t('model','saturdayshipment'),
                'values' => [
                    0 => Parcel::t('model','no'),
                    1 => Parcel::t('model','yes'),
                ]
            ],
            'servicename' => [
                'label' => Parcel::t('model','servicename'),
                'values' => [
                    'expres' => 'Expres',
                    '0900' => '0900',
                    '1200' => '1200',
                    'export' => 'Export'
                ]
            ],
            'tel' => [
                'label' => Parcel::t('model','tel'),
                'values' => [
                    0 => Parcel::t('model','no'),
                    1 => Parcel::t('model','yes'),
                ]
            ],
            'units' => [
                'label' => Parcel::t('model','units'),
                'values' => [
                    "kg" => 'Kg',
                    "boxa" => 'boxa',
                    "boxb" => 'boxb',
                    "boxc" => 'boxc',
                    "winebox3" => 'winebox3',
                    "winebox6" => 'winebox6',
                    "winebox12" => 'winebox12'
                ]
            ],
            'codattribute' => [
                'label' => Parcel::t('model','codattribute'),
                'values' => [
                    0 => 'Hotovosť',
                    3 => 'VIAMO',
                    4 => 'Platba kartou',
                ],
            ],
            'deliverytype' => [
                'label' => Parcel::t('model','deliverytype'),
                'values' => [
                    "2PT" => Parcel::t('model','terminal'),
                    "2PS" => Parcel::t('model','parcelshop')
                ]
            ],
        ];
    }

    public function name()
    {
        return Parcel::t('model','webServiceShipment');
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