<?php

namespace matejch\parcel\commands;

use matejch\parcel\models\ParcelShop;
use matejch\parcel\Parcel;
use matejch\xmlhelper\XmlHelper;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\BaseConsole;
use yii\helpers\Json;

/** @property Parcel $module */
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

        if(!$this->module->placeurl) {
            echo $this->ansiFormat("`placeurl` on set on module\n",BaseConsole::FG_GREEN);
            return ExitCode::OK;
        }

        $xml = $this->module->getContentFromUrl($this->module->placeurl);

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