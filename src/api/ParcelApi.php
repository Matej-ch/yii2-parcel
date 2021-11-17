<?php

namespace matejch\parcel\api;

use matejch\parcel\models\CifCreateAndPrintResult;
use matejch\parcel\models\CifCreateShipmentResult;
use matejch\parcel\models\Cod;
use matejch\parcel\models\DeliveryAddress;
use matejch\parcel\models\MipWebserviceUploadResult;
use matejch\parcel\models\ParcelShipment;
use matejch\parcel\models\PickupAddress;
use matejch\parcel\models\WebServicePackage;
use matejch\parcel\models\WebServicePrintResult;
use matejch\parcel\models\WebServiceShipment;
use SoapClient;
use SoapFault;
use stdClass;
use Yii;
use yii\helpers\Json;

class ParcelApi
{
    /**
     * @var SoapClient
     */
    protected $client = null;

    protected $wsdlurl = '';

    public static function connect()
    {
        $obj = new static();
        $obj->wsdlurl = Yii::$app->getModule('parcel')->wsdlurl;
        $obj->client = new SoapClient($obj->wsdlurl);
        return $obj;
    }

    public function createCifShipment($account, $post)
    {
        $sequence = new stdClass();
        $sequence->name = $account->username;
        $sequence->password = $account->password;

        $webServiceShipment = new WebServiceShipment();
        $webServiceShipment->load($post['shipment'],'WebServiceShipment');

        if(isset($post['shipment']['Cod'])) {
            $cod = new Cod();
            $cod->load($post['shipment'],'Cod');
            $webServiceShipment->cod = $cod;
        }

        if(isset($post['shipment']['PickupAddress'])) {
            $pickupAdress = new PickupAddress();
            $pickupAdress->load($post['shipment'],'PickupAddress');
            $webServiceShipment->pickupaddress = $pickupAdress;
        }

        if(isset($post['shipment']['DeliveryAddress'])) {
            $deliveryAdress = new DeliveryAddress();
            $deliveryAdress->load($post['shipment'],'DeliveryAddress');
            $webServiceShipment->deliveryaddress = $deliveryAdress;
        }

        foreach ($post['shipment']['WebServicePackage'] as $pack) {
            $package = new WebServicePackage();
            $package->load($pack,'');
            $webServiceShipment->packages[] = $package;
        }

        $sequence->webServiceShipment = $webServiceShipment->toStd();

        try {
            $result = $this->client->createCifShipment($sequence);
            $result->function = 'createCifShipment';
            ParcelShipment::create($sequence,$result);

            $resultModel = new CifCreateShipmentResult();
            $resultModel->load(Json::decode(Json::encode($result)),'createCifShipmentReturn');
            return $resultModel->toMessage();

        } catch (SoapFault $fault) {
            return "SOAP Fault: (code: {$fault->faultcode}, message: {$fault->faultstring})";
        }
    }

    public function printShipmentLabels($account)
    {
        try {
            $sequence = new stdClass();
            $sequence->aUserName = $account->username;
            $sequence->aPassword = $account->password;
            $result = $this->client->printShipmentLabels($sequence);
            $result->function = 'printShipmentLabels';
            ParcelShipment::create($sequence,$result);

            $resultModel = new WebServicePrintResult();
            $resultModel->load(Json::decode(Json::encode($result)),'printShipmentLabelsReturn');
            return $resultModel->toMessage();

        } catch (SoapFault $fault) {
            return "SOAP Fault: (code: {$fault->faultcode}, message: {$fault->faultstring})";
        }
    }

    public function printEndOfDay($account)
    {
        try {
            $sequence = new stdClass();
            $sequence->aUserName = $account->username;
            $sequence->aPassword = $account->password;
            $result = $this->client->printEndOfDay($sequence);

            $result->function = 'printEndOfDay';
            ParcelShipment::create($sequence,$result);

            $resultModel = new WebServicePrintResult();
            $resultModel->load(Json::decode(Json::encode($result)),'printEndOfDayReturn');
            return $resultModel->toMessage();
        } catch (SoapFault $fault) {
            return "SOAP Fault: (code: {$fault->faultcode}, message: {$fault->faultstring})";
        }
    }

    public function uploadMipShipments($account)
    {
        $sequence = new stdClass();
        $sequence->name = $account->username;
        $sequence->password = $account->password;

        try {
            $result = $this->client->uploadMipShipments($sequence);
            $result->function = 'uploadMipShipments';
            ParcelShipment::create($sequence,$result);

            $resultModel = new MipWebserviceUploadResult();
            $resultModel->load(Json::decode(Json::encode($result)),'uploadMipShipmentsReturn');
            return $resultModel->toMessage();

        } catch (SoapFault $fault) {
            return "SOAP Fault: (code: {$fault->faultcode}, message: {$fault->faultstring})";
        }
    }

    public function createAndPrintCifShipment($account,$post)
    {
        $sequence = new stdClass();
        $sequence->name = $account->username;
        $sequence->password = $account->password;

        $webServiceShipment = new WebServiceShipment();
        $webServiceShipment->load($post['shipment'],'WebServiceShipment');

        if(isset($post['shipment']['Cod'])) {
            $cod = new Cod();
            $cod->load($post['shipment'],'Cod');
            $webServiceShipment->cod = $cod;
        }

        if(isset($post['shipment']['PickupAddress'])) {
            $pickupAdress = new PickupAddress();
            $pickupAdress->load($post['shipment'],'PickupAddress');
            $webServiceShipment->pickupaddress = $pickupAdress;
        }

        if(isset($post['shipment']['DeliveryAddress'])) {
            $deliveryAdress = new DeliveryAddress();
            $deliveryAdress->load($post['shipment'],'DeliveryAddress');
            $webServiceShipment->deliveryaddress = $deliveryAdress;
        }

        foreach ($post['shipment']['WebServicePackage'] as $pack) {
            $package = new WebServicePackage();
            $package->load($pack,'');
            $webServiceShipment->packages[] = $package;
        }

        $sequence->webServiceShipment = $webServiceShipment->toStd();

        try {
            $result = $this->client->createAndPrintCifShipment($sequence);
            $result->function = 'createAndPrintCifShipment';

            if(isset($post['modelClass'])) {
                $result->model = $post['modelClass'];
            }

            if(isset($post['modelId'])) {
                $result->model_id = $post['modelId'];
            }

            ParcelShipment::create($sequence,$result);
            unset($result->model,$result->model_id);

            $resultModel = new CifCreateAndPrintResult();
            $resultModel->load(Json::decode(Json::encode($result)),'createAndPrintCifShipmentReturn');
            return $resultModel->toMessage();
        } catch (SoapFault $fault) {
            return "SOAP Fault: (code: {$fault->faultcode}, message: {$fault->faultstring})";
        }
    }
}