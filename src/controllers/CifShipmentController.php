<?php

namespace matejch\parcel\controllers;

use matejch\parcel\api\ParcelApi;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class CifShipmentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create','print','print-day','create-and-print'],
                        'allow' => true,
                        'roles' => $this->module->controllerAccessRules,
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $parcel = ParcelApi::connect();
        $response = $parcel->createCifShipment(ParcelAccount::findDefault(),Yii::$app->request->post());

        Yii::$app->session->setFlash('info',$response);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPrint()
    {
        $parcel = ParcelApi::connect();
        $response = $parcel->printShipmentLabels(ParcelAccount::findDefault());

        Yii::$app->session->setFlash('info',$response);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCreateAndPrint()
    {
        $parcel = ParcelApi::connect();
        $response = $parcel->createAndPrintCifShipment(ParcelAccount::findDefault(),Yii::$app->request->post());

        Yii::$app->session->setFlash('info',$response);

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPrintDay()
    {
        $parcel = ParcelApi::connect();
        $response = $parcel->printEndOfDay(ParcelAccount::findDefault());

        Yii::$app->session->setFlash('info',$response);

        return $this->redirect(Yii::$app->request->referrer);
    }
}