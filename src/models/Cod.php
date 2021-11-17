<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;

/**
 * @property string $codvalue
 * @property string|null $codretbankacc
 * @property string|null $codretbankcode
 */
class Cod extends ServiceBase
{
    public $codvalue;
    public $codretbankacc;
    public $codretbankcode;

    public function rules()
    {
        return [
            [['codvalue'], 'required'],
            [['codretbankacc','codretbankcode','codvalue'], 'string'],
            [['codvalue'], 'string', 'max' => 10],
            [['codretbankacc'], 'string', 'max' => 35],
            [['codretbankcode'], 'string', 'max' => 15],
            [['codretbankacc', 'codretbankcode','codvalue'],'trim']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['map'] = ['codretbankacc','codretbankcode'];
        return $scenarios;
    }

    public function attributeLabels()
    {
        return  [
            'codvalue' => Parcel::t('model','codvalue'),
            'codretbankacc' => Parcel::t('model','codretbankacc'),
            'codretbankcode' => Parcel::t('model','codretbankcode'),
        ];
    }

    public function attributeHints()
    {
        return  [
            'codretbankacc' => Parcel::t('model','codretbankacc_hint'),
        ];
    }

    public function attributeMaps()
    {
        return [
            'codvalue' => [
                'label' => Parcel::t('model','codvalue'),
                'type' => 'input'
            ],
            'codretbankacc' => [
                'label' => Parcel::t('model','codretbankacc'),
                'type' => 'input'
            ],
            'codretbankcode' => [
                'label' => Parcel::t('model','codretbankcode'),
                'type' => 'input'
            ]
        ];
    }

    public function name()
    {
        return Parcel::t('model','cod');
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