<?php


namespace matejch\parcel\models;


use matejch\parcel\Parcel;
use yii\base\Model;

/**
 * @property string $errors
 * @property string $warnings
*/
class WebServiceShipmentResult extends Model
{
    public $errors;
    public $warnings;

    public function rules()
    {
        return [
            [['warnings','errors'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'errors' => Parcel::t('model','errors'),
            'warnings' => Parcel::t('model','warnings'),
        ];
    }

    public function attributeHints()
    {
        return [
            'errors' => Parcel::t('model','errors_hint'),
            'warnings' => Parcel::t('model','warnings_hint'),
        ];
    }

    public function toMessage()
    {
        $html = '';

        if($this->errors) {
            $html .= "<div class='alert-danger alert'>".$this->getAttributeLabel('errors').": $this->errors</div>";
        }

        if($this->warnings) {
            $html .= "<div class='alert-warning alert'>".$this->getAttributeLabel('warnings').": $this->warnings</div>";
        }
        return $html;
    }
}