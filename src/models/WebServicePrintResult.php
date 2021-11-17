<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;
use yii\helpers\Html;

/**
 * @property string $errors
 * @property string $documentUrl
 */
class WebServicePrintResult extends Model
{
    public $errors;
    public $documentUrl;

    public function rules()
    {
        return [
            [['documentUrl','errors'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'errors' => Parcel::t('model','errors'),
            'documentUrl' => Parcel::t('model','documentUrl'),
        ];
    }

    public function toMessage()
    {
        $html = '';
        if($this->errors) {
            $html .= "<div class='alert-danger alert'>".$this->getAttributeLabel('errors').": $this->errors</div>";
        }

        if($this->documentUrl) {
            $html .= Html::a(Parcel::t('msg','link_download'),$this->documentUrl,['class'=>'btn btn-default']);
            $html .= "<p>".Parcel::t('msg','link_download_hint')."</p>";
        }

        return $html;
    }
}