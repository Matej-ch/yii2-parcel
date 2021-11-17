<?php

namespace matejch\parcel\controllers;

use matejch\parcel\models\ParcelShipment;
use matejch\parcel\Parcel;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ParcelShipmentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','view','delete','change-state','remove-from-protocol','remove-from-protocol-multiple'],
                        'allow' => true,
                        'roles' => $this->module->controllerAccessRules,
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ParcelShipmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ParcelShipment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Parcel::t('msg','no_page'));
    }

    public function actionChangeState($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if(!$model->changeValidState()) {
            return ['success' => false, 'message' => Yii::t('site/dhl', 'status_not_changed')];
        }

        if($model->is_active) {
            return ['success' => true, 'is_active' => true];
        }

        return ['success' => true, 'is_active' => false];
    }

    public function actionRemoveFromProtocol($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model->removeFromProtocol()) {
            return ['success' => true];
        }

        return ['success' => false, 'message' => Yii::t('site/dhl', 'not_removed_from_protokol')];
    }

    public function actionRemoveFromProtocolMultiple($ids)
    {
        $cleanIDs = Helpers::cleanGetIds($ids);
        foreach ($cleanIDs as $cleanID) {
            $this->findModel($cleanID)->removeFromProtocol();
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

}