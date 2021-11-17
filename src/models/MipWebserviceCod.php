<?php


namespace matejch\parcel\models;

/**
 * @property string $codAttr
*/
class MipWebserviceCod extends Cod
{
    public $codAttr;

    public function rules()
    {
        return parent::rules();
    }

    public function attributeLabels()
    {
        return parent::attributeLabels();
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