<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property string|null $cargo24h
 * @property string|null $cargoattr
 * @property  MipWebserviceCod|null $cod
 * @property  ConsumerAddress|null $consumer
 * @property  string|null $deliverydate
 * @property  string|null $deliveryremark
 * @property  string|null $deliverytimefrom
 * @property  string|null $deliverytimeto
 * @property  string|null $deliverytype
 * @property  string|null $hypermarket
 * @property  int|null $insurcurr
 * @property  float|null $insurvalue
 * @property  string|null $internalnrtype
 * @property  int|null $numberofeuropalettes
 * @property  MipWebservicePackage[] $packages
 * @property  string $pdely
 * @property  ReceiverAddress $receiver
 * @property  int|null $receivernotifytype
 * @property  boolean|null $recipientpay
 * @property  boolean|null $returnshipment
 * @property  string|null $saturdayattr
 * @property  boolean|null $saturdayshipment
 * @property  SenderAddress $sender
 * @property  string|null $servicename
 * @property  string|null $shipdate
 * @property  string|null $shipinfo1
 * @property  string|null $shipinfo2
 * @property  string|null $shipinfo3
 * @property  string|null $shipinfo4
 * @property  string|null $tel
 * @property  string|null $units
*/
class MipWebserviceShipment extends Model
{
    public $cargo24h;
    public $cargoattr;
    public $cod;
    public $consumer;
    public $deliverydate;
    public $deliveryremark;
    public $deliverytimefrom;
    public $deliverytimeto;
    public $deliverytype;
    public $hypermarket;
    public $insurcurr;
    public $insurvalue;
    public $internalnrtype;
    public $numberofeuropalettes;
    public $packages;
    public $pdely;
    public $receiver;
    public $receivernotifytype;
    public $recipientpay;
    public $returnshipment;
    public $saturdayattr;
    public $saturdayshipment;
    public $sender;
    public $servicename;
    public $shipdate;
    public $shipinfo1;
    public $shipinfo2;
    public $shipinfo3;
    public $shipinfo4;
    public $tel;
    public $units;


    public function rules()
    {
        return [
            [['cargo24h','cargoattr'],'string','max' => 2],
            [['cod','consumer','packages','receiver','sender'],'safe'],
            [['deliverydate','shipdate','shipinfo1','shipinfo2','shipinfo3','shipinfo4'],'string','max' => 10],
            [['deliveryremark'],'string','max' => 150],
            [['deliverytimefrom','deliverytimeto'],'string','max' => 5],
            [['deliverytype','hypermarket','tel'],'string','max' => 1],
            [['insurcurr','numberofeuropalettes','receivernotifytype'],'integer'],
            [['insurcurr'],'in','range'=>range(0,1)],
            [['receivernotifytype'],'in','range'=>range(0,3)],
            [['insurvalue'],'number'],
            [['internalnrtype','saturdayattr'],'string','max' => 2],
            [['pdely'],'string','max' => 35],
            [['recipientpay','returnshipment','saturdayshipment'],'boolean'],
            [['servicename','units'],'string','max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'cargo24h' => Parcel::t('model','cargo24h'),
            'cargoattr' => Parcel::t('model','cargoattr'),
            'cod' => Parcel::t('model','cod'),
            'consumer' => Parcel::t('model','consumer'),
            'deliverydate' => Parcel::t('model','deliverydate'),
            'deliveryremark' => Parcel::t('model','deliveryremark'),
            'deliverytimefrom' => Parcel::t('model','deliverytimefrom'),
            'deliverytimeto' => Parcel::t('model','deliverytimeto'),
            'deliverytype' => Parcel::t('model','deliverytype_mip'),
            'hypermarket' => Parcel::t('model','hypermarket'),
            'insurcurr' => Parcel::t('model','insurcurr'),
            'insurvalue' => Parcel::t('model','insurvalue'),
            'internalnrtype' => Parcel::t('model','internalnrtype'),
            'numberofeuropalettes' => Parcel::t('model','numberofeuropalettes'),
            'packages' => Parcel::t('model','packages_mip'),
            'pdely' => Parcel::t('model','pdely'),
            'receiver' => Parcel::t('model','receiver'),
            'receivernotifytype' => Parcel::t('model','receivernotifytype'),
            'recipientpay' => Parcel::t('model','recipientpay'),
            'returnshipment' => Parcel::t('model','returnshipment'),
            'saturdayattr' => Parcel::t('model','saturdayattr'),
            'saturdayshipment' => Parcel::t('model','saturdayshipment'),
            'sender' => Parcel::t('model','sender'),
            'servicename' => Parcel::t('model','servicename'),
            'shipdate' => Parcel::t('model','shipdate'),
            'shipinfo1' => Parcel::t('model','shipinfo1'),
            'shipinfo2' => Parcel::t('model','shipinfo2'),
            'shipinfo3' => Parcel::t('model','shipinfo3'),
            'shipinfo4' => Parcel::t('model','shipinfo4'),
            'tel' =>  Parcel::t('model','tel'),
            'units' =>  Parcel::t('model','units'),
        ];
    }

    public function attributeHints()
    {
        return [
            'deliverydate' => Parcel::t('model','deliverydate_hint'),
            'deliveryremark' => Parcel::t('model','deliveryremark_hint'),
            'deliverytimefrom' => Parcel::t('model','deliverytimefrom_hint'),
            'deliverytimeto' => Parcel::t('model','deliverytimeto_hint'),
            'deliverytype' => Parcel::t('model','deliverytype_mip_hint'),
            'insurcurr' => Parcel::t('model','insurcurr_hint'),
            'pdely' => Parcel::t('model','pdely_hint'),
            'receivernotifytype' => Parcel::t('model','receivernotifytype_hint'),
            'recipientpay' => Parcel::t('model','recipientpay_hint'),
            'returnshipment' => Parcel::t('model','returnshipment_hint'),
            'saturdayshipment' => Parcel::t('model','saturdayshipment_hint'),
            'shipdate' => Parcel::t('model','shipdate_hint'),
        ];
    }

    public function attributeMaps()
    {
        return [
            'cargo24h' => [
                'label' => Parcel::t('model','cargo24h'),
                'type' => 'input',
            ],
            'cargoattr' => [
                'label' => Parcel::t('model','cargoattr'),
                'type' => 'input',
            ],
            'deliverydate' => Parcel::t('model','deliverydate'),
            'deliveryremark' => Parcel::t('model','deliverydate'),
            'deliverytimefrom' => Parcel::t('model','deliverydate'),
            'deliverytimeto' => Parcel::t('model','deliverydate'),

            'deliverytype' => [
                'label' => Parcel::t('model','deliverydate'),
                'values' => [
                    '2B' => 'prázdne',
                    '2C' => "+",
                    '2PT-BoxA' => "1",
                    '2PT-BoxB' => "2",
                    '2PT-BoxC' => "3",
                    '2PS' => "4"
                ],
            ],
            'hypermarket' => [
                'label' => Parcel::t('model','hypermarket'),
                'values' => [
                    0 => Parcel::t('model','no'),
                    1 => Parcel::t('model','yes'),
                ],
            ],
            'insurcurr' => [
                'label' => Parcel::t('model','insurcurr'),
                'values' => [
                    0 => Parcel::t('model','local'),
                    1 => 'Euro',
                ],
            ],
            'insurvalue' => [
                'label' => Parcel::t('model','insurvalue'),
                'type' => 'input',
            ],
            'internalnrtype' => [
                'label' => Parcel::t('model','internalnrtype'),
                'type' => 'input',
            ],
            'numberofeuropalettes' => [
                'label' => Parcel::t('model','numberofeuropalettes'),
                'type' => 'input',
            ],
            'pdely' => Parcel::t('model','pdely'),

            'servicename' => [
                'label' => Parcel::t('model','servicename'),
                'values' => [
                    'expres' => 'Expres',
                    '0900' => '0900',
                    '1200' => '1200',
                    'export' => 'Export'
                ]
            ],
            'receivernotifytype' => [
                'label' => Parcel::t('model','receivernotifytype'),
                'values' => [
                    0 => Parcel::t('model','disabled'),
                    1 => Parcel::t('model','email'),
                    2 => Parcel::t('model','sms'),
                    3 => Parcel::t('model','both email and sms')
                ],
            ],

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
            'shipdate' => Parcel::t('model','shipdate'),

            'shipinfo1' => Parcel::t('model','shipinfo1'),
            'shipinfo2' => Parcel::t('model','shipinfo2'),
            'shipinfo3' => Parcel::t('model','shipinfo3'),
            'shipinfo4' => Parcel::t('model','shipinfo4'),

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
        ];
    }

    public function name()
    {
        return Parcel::t('model','mipWebserviceShipment');
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