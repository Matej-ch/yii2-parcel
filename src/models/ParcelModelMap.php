<?php

namespace matejch\parcel\models;

use matejch\parcel\Parcel;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "parcel_model_map".
 *
 * @property int $id
 * @property string $name
 * @property string|null $map
 * @property string|null $function
 * @property string|null $model
 * @property int $default
 */
class ParcelModelMap extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parcel_model_map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['name'],'unique'],
            [['map'], 'string'],
            [['function'], 'string', 'max' => 128],
            [['model','name'], 'string', 'max' => 256],
            [['name'],'trim'],
            [['name'],'filter','filter'=>'strip_tags','skipOnArray' => true],
            [['default'], 'boolean'],
            [['default'], 'default', 'value' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Parcel::t('model','id'),
            'name' => Parcel::t('model','map_name'),
            'map' => Parcel::t('model','map'),
            'function' => Parcel::t('model','function'),
            'model' => Parcel::t('model','model'),
            'default' => Parcel::t('model','default_map'),
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if($this->default) {
            foreach (self::find()->all() as $map) {
                /** @var ParcelModelMap $map */
                $map->default = false;
                $map->update();
            }
        }

        return true;
    }

    public static function getFunctions()
    {
        return [
            'createCifShipment' => Parcel::t('msg','createCifShipment'),
            'createMipShipment' => Parcel::t('msg','createMipShipment')
        ];
    }

    public static function cifShipmentMap($scenario = 'default')
    {
        $models = [
            new WebServicePackage(['scenario' => $scenario]),
            new WebServiceShipmentType(),
            new Cod(['scenario' => $scenario]),
            new WebServiceShipment(['scenario' => $scenario]),
            new DeliveryAddress(),
            new PickupAddress()
        ];

        $names = array_map(function ($m) {
            return $m->getClassName();
        },$models);

        return array_combine($names,$models);
    }

    public static function mipShipmentMap($scenario = 'default')
    {
        $models = [
            new MipWebserviceCod(['scenario' => $scenario]),
            new MipWebServiceShipment(),
            new ReceiverAddress(),
            new SenderAddress(),
            new ConsumerAddress(['scenario' => $scenario])
        ];

        $names = array_map(function ($m) {
            return $m->getClassName();
        },$models);

        return array_combine($names,$models);
    }

    public static function prepareMap($map)
    {
        return Json::encode(array_map(function($m) {
            return array_filter($m, function($v) { return !is_null($v) && $v !== ''; });
        },$map));
    }

}
