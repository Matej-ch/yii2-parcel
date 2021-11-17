<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property array|null $packageInfo
 * @property array|null $result
 *
 */
class CifCreateShipmentResult extends Model
{
    public $result;

    public $packageInfo;

    public function rules()
    {
        return [
            [['packageInfo','result'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'errors' => Parcel::t('model','result'),
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
            foreach ($this->packageInfo['item'] as $item) {
                $packages = new PackageInfo();
                $packages->load($item,'');
                $html .= $packages->toMessage();
            }
        }

        return $html;
    }
}