<?php


namespace matejch\parcel\models;


use yii\base\Model;

abstract class ServiceBase extends Model
{
    public function toStd()
    {
        $std = new \stdClass();
        foreach ($this->attributes as $attr => $value) {
            if($value instanceof ServiceBase) {
                $std->{$attr} = $value->toStd();
            } else if(is_array($value)) {
                foreach ($value as $v) {
                    $std->{$attr}[] = $v->toStd();
                }
            } else {
                $std->{$attr} = $value;
            }
        }

        return $std;
    }
}