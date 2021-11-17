<?php

namespace matejch\parcel\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

class PickupAddressController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['get-data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    public function actionGetData()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $mapModel = ParcelModelMap::findOne(['id' => Yii::$app->request->get('map')]);
        $map = Json::decode($mapModel['map']);

        $addressModel = $this->module->pickUpAddressModel::findOne(['id' => Yii::$app->request->get('address')]);

        $data = [];

        foreach ($map['PickupAddress'] as $key => $addressAttribute) {
            if($addressModel->hasAttribute($addressAttribute)) {
                $data[strtolower($key)] = $addressModel->{$addressAttribute};
            } else {
                $data[strtolower($key)] = $addressAttribute;
            }
        }
        return ['success' => true,'values' => $data];
    }
}