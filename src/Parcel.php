<?php

namespace matejch\parcel;

use matejch\parcel\api\ParcelApi;
use matejch\parcel\assets\ParcelAsset;
use matejch\parcel\models\ParcelAccount;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\console\Application;

class Parcel extends Module
{
    public $controllerNamespace = 'matejch\parcel\controllers';

    public $defaultRoute = 'parcel/index';

    /** @var string url used for connection to SOAP, mandatory */
    public $wsdlurl = '';

    /** @var string url used if you want to load parcel shops from their file, not mandatory */
    public $placeurl;

    /** @var array $controllerAccessRules can contain rbac rules or simple ['@'] */
    public $controllerAccessRules = ['admin'];

    /** @var string $key set key for data encryption*/
    public $key = '';

    /**
     * @var array $models at least one model class must be set in array
     * used for mapping attributes of your model to parcel class
     */
    public $models = null;

    /** @var string $pickUpAddressModel full path to your address model */
    public $pickUpAddressModel;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        \Yii::setAlias('@matejch/parcel', __DIR__);

        if (Yii::$app instanceof Application) {
            $this->controllerNamespace = 'matejch\parcel\commands';
        } else {
            ParcelAsset::register(Yii::$app->view);
        }

        $this->registerTranslations();

        if(!$this->wsdlurl) {
            throw new InvalidConfigException('Please set `wsdlurl` attribute');
        }

        if(!is_array($this->controllerAccessRules)) {
            throw new InvalidConfigException('`controllerAccessRules` must be array');
        }

        if(!$this->key) {
            throw new InvalidConfigException('`key` must be configured as non-empty string');
        }

        if(!$this->models) {
            throw new InvalidConfigException('`model` must be configured as array with at least one model');
        }
    }

    public function registerTranslations()
    {
        if (Yii::$app->has('i18n')) {
            Yii::$app->i18n->translations['parcel/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
                'basePath' => '@matejch/parcel/messages',
                'fileMap' => [
                    'parcel/msg' => 'msg.php',
                    'parcel/model' => 'model.php',
                ],
            ];
        }
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('parcel/' . $category, $message, $params, $language);
    }

    public static function createAndPrintCifShipment($post)
    {
        $parcel = ParcelApi::connect();

        return $parcel->createAndPrintCifShipment(ParcelAccount::findDefault($post['accountId']),$post);
    }

    public static function printCifShiptment()
    {
        $parcel = ParcelApi::connect();

        return $parcel->printShipmentLabels(ParcelAccount::findDefault());
    }

    public static function createCifShiptment($post)
    {
        $parcel = ParcelApi::connect();

        return $parcel->createCifShipment(ParcelAccount::findDefault(),$post);
    }

    public static function printEndOfTheDay()
    {
        $parcel = ParcelApi::connect();

        return $parcel->printEndOfDay(ParcelAccount::findDefault());
    }

    public function getContentFromUrl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}