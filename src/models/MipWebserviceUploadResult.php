<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property int $numberofmippackages
 * @property int $numberofmipshipment
 * @property array|null $shipmentresult
 */
class MipWebserviceUploadResult extends Model
{
    public $numberofmippackages;
    public $numberofmipshipment;
    public $shipmentresult;

    public function rules()
    {
        return [
            [['numberofmippackages','numberofmipshipment'],'integer'],
            [['shipmentresult'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'numberofmippackages' => Parcel::t('model','numberofmippackages'),
            'numberofmipshipment' => Parcel::t('model','numberofmipshipment'),
            'shipmentresult' => Parcel::t('model','shipmentresult'),
        ];
    }

    public function toMessage()
    {
        $html = '';

        if(isset($this->numberofmippackages)) {
            $html .= "<p>".$this->getAttributeLabel('numberofmippackages') . ": $this->numberofmippackages</p>";
        }

        if(isset($this->numberofmipshipment)) {
            $html .= "<p>".$this->getAttributeLabel('numberofmipshipment') . ": $this->numberofmipshipment</p>";
        }

        if($this->shipmentresult) {
            $shipResult = new WebServiceShipmentResult();
            $shipResult->load($this->shipmentresult,'');
            $html .= $shipResult->toMessage();
        }

        return $html;
    }
}