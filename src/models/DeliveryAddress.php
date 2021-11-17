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
class DeliveryAddress extends ServiceBase
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
            [['zip'], 'string', 'max' => 15],
            [['email'], 'string', 'max' => 70],
            [['phone'], 'string', 'max' => 30],
        ];
    }

    public function attributeLabels()
    {
        return  [
            'city' => Parcel::t('model','city_del'),
            'contactPerson' => Parcel::t('model','contactPerson_del'),
            'country' => Parcel::t('model','country_del'),
            'email' => Parcel::t('model','email_del'),
            'mobile' => Parcel::t('model','mobile_del'),
            'name' => Parcel::t('model','name_del'),
            'street' => Parcel::t('model','street_del'),
            'zip' => Parcel::t('model','zip_del'),
            'phone' => Parcel::t('model','phone_del'),
        ];
    }

    public function attributeHints()
    {
        return [
            'street' => Parcel::t('model','street_hint'),
        ];
    }

    public function attributeMaps()
    {
        return array_merge($this->attributeLabels(),[
            'country' => ['label' => Parcel::t('model','country'),'values'=>[
                'SK' => 'SK',
                'CZ' => 'CZ',
                'PL' => 'PL'
            ]]
        ]);
    }

    public function name()
    {
        return Parcel::t('model','deliveryAddress');
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