<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property string $appellation
 * @property string $contactperson
 * @property string $name1
 * @property string $name2
 * @property string $name3
 * @property string $name4
 * @property string $name5
 * @property string $name6
 * @property string $zip
 * @property string $city
 * @property string $notused
 * @property string $street
 * @property string $housenr
 * @property string $housenrext
 * @property string $country
 * @property string $phone
 * @property string $email
 * @property string $mobile
 */
class ReceiverAddress extends Model
{
    public $appellation;
    public $contactperson;
    public $name1;
    public $name2;
    public $name3;
    public $name4;
    public $name5;
    public $name6;
    public $zip;
    public $city;
    public $notused;
    public $street;
    public $housenr;
    public $housenrext;
    public $country;
    public $phone;
    public $email;
    public $mobile;

    public function rules()
    {
        return [
            [['city','appellation','country','email','mobile','zip','street','name1'],'required'],
            [['appellation'],'string','max'=>15],
            [['contactperson','name1','name2','name3','name4','name5','name6','city','street','mobile'],'string','max'=>35],
            [['zip','notused'],'string','max'=>10],
            [['housenr'],'string','max'=>4],
            [['housenrext'],'string','max'=>6],
            [['country'],'string','max'=>3],
            [['email'],'string','max'=>70],
            [['phone'],'string','max'=>30],
            [['appellation', 'contactperson', 'name1', 'name2', 'name3', 'name4', 'name5',
                'name6', 'zip', 'city', 'notused', 'street', 'housenr', 'housenrext',
                'country', 'phone', 'email', 'mobile'],'trim'],
            [['appellation', 'contactperson', 'name1', 'name2', 'name3', 'name4',
                'name5', 'name6', 'zip', 'city', 'notused', 'street', 'housenr',
                'housenrext', 'country', 'phone', 'email', 'mobile'],'filter',
                'filter' => 'strip_tags','skipOnArray' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'appellation' => Parcel::t('model','appellation'),
            'contactperson' => Parcel::t('model','contactperson'),
            'name1' => Parcel::t('model','name1'),
            'name2' => Parcel::t('model','name2'),
            'name3' => Parcel::t('model','name3'),
            'name4' => Parcel::t('model','name4'),
            'name5' => Parcel::t('model','name5'),
            'name6' => Parcel::t('model','name6'),
            'zip' => Parcel::t('model','zip'),
            'city' => Parcel::t('model','city'),
            'notused' => Parcel::t('model','notused'),
            'street' => Parcel::t('model','street'),
            'housenr' => Parcel::t('model','housenr'),
            'housenrext' => Parcel::t('model','housenrext'),
            'country' => Parcel::t('model','country'),
            'phone' => Parcel::t('model','phone'),
            'email' => Parcel::t('model','email'),
            'mobile' => Parcel::t('model','mobile'),
        ];
    }

    public function attributeMaps()
    {
        return array_merge($this->attributeLabels(),[
            'country' => [
                'label' => Parcel::t('model','country'),
                'values'=>[
                    'SK' => 'SK',
                    'CZ' => 'CZ',
                    'PL' => 'PL'
                ]
            ]
        ]);
    }

    public function name()
    {
        return Parcel::t('model','receiver');
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