<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property string $refNr
 * @property string $shipNr
 * @property integer $packageNo
 *
 */
class PackageInfo extends Model
{
    public $refNr;
    public $shipNr;
    public $packageNo;

    public function rules()
    {
        return [
            [['refNr'],'string','max' => 35],
            [['shipNr'],'string','max' => 100],
            [['packageNo'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'refNr' => Parcel::t('model','refNr'),
            'shipNr' => Parcel::t('model','shipNr'),
            'packageNo' => Parcel::t('model','packageNo'),
        ];
    }

    public function toMessage()
    {
        return "<div>{$this->getAttributeLabel('refNr')}: $this->refNr,
                {$this->getAttributeLabel('shipNr')}: $this->shipNr, 
                {$this->getAttributeLabel('packageNo')}: $this->packageNo</div>";
    }


}