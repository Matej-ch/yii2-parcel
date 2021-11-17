<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property string $city
 * @property string $contactPerson
 * @property string $country
 * @property string $email
 * @property string $mobile
 * @property string $name
 * @property string|null $phone
 * @property string $street
 * @property string $zip
 */
class PickupAddress extends ServiceBase
{

    public $city;
    public $contactPerson;
    public $country;
    public $email;
    public $mobile;
    public $name;
    public $phone;
    public $street;
    public $zip;

    public function rules()
    {
        return [
            [['city','contactPerson','country','email','mobile','zip','street','name'], 'required'],
            [['city','contactPerson','country','email','mobile','phone','zip','street','name'], 'string'],
            [['city','contactPerson','country','email','mobile','phone','zip','street','name'],'trim'],
            [['city','street','name','contactPerson','mobile'], 'string', 'max' => 35],
            [['country'], 'string', 'max' => 3],
            [['zip'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 70],
            [['phone'], 'string', 'max' => 30],
        ];
    }

    public function attributeLabels()
    {
        return  [
            'city' => Parcel::t('model','pick_city'),
            'contactPerson' => Parcel::t('model','pick_contactPerson'),
            'country' => Parcel::t('model','pick_country'),
            'email' => Parcel::t('model','pick_email'),
            'mobile' => Parcel::t('model','pick_mobile'),
            'name' => Parcel::t('model','pick_name'),
            'street' => Parcel::t('model','pick_street'),
            'zip' => Parcel::t('model','pick_zip'),
            'phone' => Parcel::t('model','pick_phone'),
        ];
    }

    public function attributeHints()
    {
        return [
            'street' => Parcel::t('model','pick_street_hint'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['map'] = [];
        return $scenarios;
    }

    public function attributeMaps()
    {
        return array_merge($this->attributeLabels(),[
            'country' => ['label' => Parcel::t('model','pick_country'),'values'=>[
                'SK' => 'SK',
                'CZ' => 'CZ',
                'PL' => 'PL'
            ]]
        ]);
    }

    public function name()
    {
        return Parcel::t('model','pickupAddress');
    }

    public function isPickUpAddress()
    {
        return true;
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}