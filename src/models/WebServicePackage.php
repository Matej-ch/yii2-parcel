<?php


namespace matejch\parcel\models;


use Yii;

/**
 * @property string $reffnr
 * @property string $weight
 */
class WebServicePackage extends ServiceBase
{

    public $reffnr;
    public $weight;

    public function rules()
    {
        return [
            [['reffnr','weight'], 'required'],
            [['reffnr','weight'], 'string'],
            [['weight'], 'string', 'max' => 10],
            [['reffnr'], 'string', 'max' => 35],
        ];
    }

    public function attributeLabels()
    {
       return [
           'reffnr' => Yii::t('parcel/model','reffnr'),
           'weight' => Yii::t('parcel/model','weight'),
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
        return [
            'reffnr' => Yii::t('parcel/model','reffnr'),
            'weight' => [
                'type' => 'input',
                'label' => Yii::t('parcel/model','weight')
            ]
        ];
    }

    public function name()
    {
        return Yii::t('parcel/model','webServicePackage');
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