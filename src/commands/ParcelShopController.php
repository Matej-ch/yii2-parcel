<?php

namespace matejch\parcel\commands;

use matejch\parcel\models\ParcelShop;
use matejch\xmlhelper\XmlHelper;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\helpers\Json;

class ParcelShopController extends Controller
{
    /**
     * Load parcel shops into table for future use
     * @return int
     * @throws \Exception
     */
    public function actionInit(): int
    {
        $parser = new XmlHelper();
        $xml = $this->fileGetContentsCurl($this->module->placeurl);

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

    private function fileGetContentsCurl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}