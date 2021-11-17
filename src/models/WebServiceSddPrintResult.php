<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;
use yii\helpers\Html;

/**
 * @property string $errors
 * @property string $labelUrl
 * @property string $reportsUrl
 */
class WebServiceSddPrintResult extends Model
{
    public $errors;
    public $labelUrl;
    public $reportsUrl;

    public function rules()
    {
        return [
            [['reportsUrl','errors','labelUrl'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'errors' => Parcel::t('model','errors'),
            'labelUrl' => Parcel::t('model','labelUrl'),
            'reportsUrl' => Parcel::t('model','reportsUrl'),
        ];
    }

    public function toMessage()
    {
        $html = '';

        if($this->errors) {
            $html .= "<div class='alert-danger alert'>".$this->getAttributeLabel('errors').": $this->errors</div>";
        }

        if($this->labelUrl) {
            $html .= "<p>".$this->getAttributeLabel('labelUrl').": ".Html::a(Parcel::t('msg','link_download'),$this->labelUrl,['class'=>'btn btn-default'])."</p>";
        }

        if($this->reportsUrl) {
            $html .= "<p>".$this->getAttributeLabel('reportsUrl').": ".Html::a(Parcel::t('msg','link_download'),$this->reportsUrl,['class'=>'btn btn-primary'])."</p>";
        }

        return $html;
    }
}