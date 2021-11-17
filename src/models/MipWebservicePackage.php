<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property string $refnr1
 * @property string $refnr2
 * @property string $refnr3
 * @property string $scannedbarcode
 * @property string $weight
*/
class MipWebservicePackage extends Model
{
    public $refnr1;
    public $refnr2;
    public $refnr3;
    public $scannedbarcode;
    public $weight;

    public function rules()
    {
        return [
            [['refnr1'], 'required'],
            [['refnr1','refnr2','refnr3','scannedbarcode'], 'string','max' => 35],
            [['weight'], 'string','max' => 8],
        ];
    }

    public function attributeLabels()
    {
        return [
            'refnr1' => Parcel::t('model','refnr1'),
            'refnr2' => Parcel::t('model','refnr2'),
            'refnr3' => Parcel::t('model','refnr3'),
            'scannedbarcode' => Parcel::t('model','scannedbarcode'),
            'weight' => Parcel::t('model','weight')];
    }

    public function attributeHints()
    {
        return [
            'refnr2' => Parcel::t('model','refnr2_hint'),
            'refnr3' => Parcel::t('model','refnr3_hint'),
            'scannedbarcode' => Parcel::t('model','scannedbarcode_hint'),
        ];
    }

    public function attributeMaps()
    {
        return $this->attributeLabels();
    }
}