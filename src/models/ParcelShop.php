<?php

namespace matejch\parcel\models;

use matejch\parcel\Parcel;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "parcel_shop".
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $place_id
 * @property string|null $description
 * @property string|null $address
 * @property string|null $city
 * @property string|null $zip
 * @property string|null $virtualzip
 * @property string|null $countryISO
 * @property int|null $status
 * @property string|null $gps
 * @property int|null $center
 * @property string|null $workDays
 */
class ParcelShop extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parcel_shop';
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if($this->workDays) {
            $this->parseWorkDays();
        } else {
            $this->workDays = '';
        }

        return true;
    }

    public function rules()
    {
        return [
            [['description', 'gps'], 'string'],
            [['status', 'center'], 'integer'],
            [['type'], 'string', 'max' => 64],
            [['place_id', 'address', 'city'], 'string', 'max' => 256],
            [['zip', 'virtualzip'], 'string', 'max' => 16],
            [['countryISO'], 'string', 'max' => 3],
            [['workDays'],'safe'],
            [['description', 'gps','type','place_id', 'address', 'city','zip', 'virtualzip','countryISO'],'trim']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Parcel::t('model', 'id'),
            'type' => Parcel::t('model', 'type'),
            'place_id' => Parcel::t('model', 'place_id'),
            'description' => Parcel::t('model', 'description'),
            'address' => Parcel::t('model', 'address'),
            'city' => Parcel::t('model', 'city'),
            'zip' => Parcel::t('model', 'zip'),
            'virtualzip' => Parcel::t('model', 'virtualzip'),
            'countryISO' => Parcel::t('model', 'countryISO'),
            'status' => Parcel::t('model', 'status'),
            'gps' => Parcel::t('model', 'gps'),
            'center' => Parcel::t('model', 'center'),
            'workDays' => Parcel::t('model', 'workDays'),
        ];
    }

    private function parseWorkDays()
    {
        $days = [];
        foreach ($this->workDays['workday'] as $workDay) {
            $days[$workDay['@attributes']['date']] = $workDay['workHours'];
        }

        $this->workDays = Json::encode($days);
    }

    public function getWorkDays()
    {
        if($this->workDays) {
            $this->workDays = Json::decode($this->workDays);
            $parsedDays = '';
            foreach ($this->workDays as $key => $workDay) {
                $parsedDays .= "<div><span class='font-bold'>$key:</span> $workDay</div>";
            }
            return $parsedDays;
        }
        return '';
    }
}