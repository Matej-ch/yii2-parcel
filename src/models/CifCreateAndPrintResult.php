<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;
use yii\helpers\Html;

/**
 *
 * @property string|null $documentUrl
 * @property array|null $packageInfo
 * @property array|null $result
 *
*/
class CifCreateAndPrintResult extends Model
{
    public $result;

    public $packageInfo;

    public $documentUrl;

    public function rules()
    {
        return [
            [['documentUrl'],'string'],
            [['packageInfo','result'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'errors' => Parcel::t('model','result'),
            'documentUrl' => Parcel::t('model','documentUrl'),
            'packageInfo' => Parcel::t('model','packageInfo'),
        ];
    }

    public function toMessage()
    {
        $html = '';

        if($this->result) {
            $res  = new WebServiceShipmentResult();
            $res->load($this->result,'');
            $html .= $res->toMessage();
        }

        if($this->packageInfo && $this->packageInfo['item']) {
            foreach ($this->packageInfo as $item) {
                $package = new PackageInfo();
                $package->load($item,'');
                $html .= $package->toMessage();
            }
        }

        if($this->documentUrl) {
            $html .= Html::a($this->getAttributeLabel('documentUrl'),$this->documentUrl,['class'=>'btn btn-default']);
            $html .= "<p>".Parcel::t('msg','link_download_hint')."</p>";
        }

        return $html;
    }
}