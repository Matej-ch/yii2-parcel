<?php

namespace matejch\parcel\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\helpers\Json;

class ParcelShopController extends Controller
{
    public function actionInit()
    {
        $parser = new XmlHelper();
        $xml = FileHelper::fileGetContentsCurl($this->module->placeurl);

        $parsedData = $parser->parse($xml,'xml');

        foreach ($parsedData['place'] as $data) {
            $shop = new ParcelShop();
            $shop->gps = Json::encode(['gpsLat' => $data['gpsLat'],'gpsLong'=> $data['gpsLong']]);
            $shop->place_id = $data['id'];
            $shop->load($data,'');
            $shop->id = null;
            if($shop->save()) {
                echo $this->ansiFormat("Parcel shop {$data['id']} saved\n",BaseConsole::FG_GREEN);
            } else {
                echo $this->ansiFormat("Parcel shop {$data['id']} not saved. errors: " . implode(', ',$shop->getFirstErrors()) . "\n",BaseConsole::FG_RED);
            }
        }

        return ExitCode::OK;
    }
}