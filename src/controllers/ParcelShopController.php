<?php

namespace matejch\parcel\controllers;

use matejch\parcel\models\ParcelShop;
use matejch\parcel\models\ParcelShopSearch;
use matejch\parcel\Parcel;
use matejch\xmlhelper\XmlHelper;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/** @property Parcel $module */
class ParcelShopController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','view','populate-records'],
                        'allow' => true,
                        'roles' => $this->module->controllerAccessRules,
                    ]
                ],
            ],
        ];
    }

    /**
     * Lists all SolverAltPlace models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParcelShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SolverAltPlace model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the SolverAltPlace model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParcelShop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParcelShop::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Parcel::t('msg','no_page'));
    }

    public function actionPopulateRecords()
    {
        $parser = new XmlHelper();
        $xml = $this->module->getContentFromUrl($this->module->placeurl);

        $parsedData = $parser->parse($xml,'xml');
        $message = '';
        foreach ($parsedData['place'] as $data) {
            $shop = new ParcelShop();
            $shop->gps = Json::encode(['gpsLat' => $data['gpsLat'],'gpsLong'=> $data['gpsLong']]);
            $shop->place_id = $data['id'];
            $shop->load($data,'');
            $shop->id = null;
            if($shop->save()) {
                $message .= "<span class='alert-success'>Parcel shop {$data['id']} saved</span><br>";
            } else {
                $message .= "<span class='alert-danger'>Parcel shop {$data['id']} Parcel shop {$data['id']} not saved. errors: " . implode(', ',$shop->getFirstErrors())."</span><br>";
            }
        }
        Yii::$app->session->setFlash('info',$message);
        return $this->redirect(Yii::$app->request->referrer);
    }
}