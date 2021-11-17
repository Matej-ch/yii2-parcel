<?php

namespace matejch\parcel\controllers;

use matejch\parcel\models\ParcelModelMap;
use matejch\parcel\Parcel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ParcelModelMapController extends Controller
{
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','update','create','delete','set-default'],
                        'allow' => true,
                        'roles' => $this->module->controllerAccessRules,
                    ],
                    [
                        'actions' => ['get-data'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
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
        $dataProvider = new ActiveDataProvider([
            'query' => ParcelModelMap::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new ParcelModelMap();

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if(isset($post['ParcelModelMap']['map'])) {
                $post['ParcelModelMap']['map'] = ParcelModelMap::prepareMap($post['ParcelModelMap']['map']);
            }

            if ($model->load($post) && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        $pickUpAdrressModel = Parcel::getInstance()->pickUpAddressModel;

        return $this->render('create', [
            'model' => $model,
            'models' => array_combine($this->module->models,$this->module->models),
            'functions' => $model->getFunctions(),
            'pickUpAddress' => new $pickUpAdrressModel(),
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();

            if(isset($post['ParcelModelMap']['map'])) {
                $post['ParcelModelMap']['map'] = ParcelModelMap::prepareMap($post['ParcelModelMap']['map']);
            }

            if ($model->load($post) && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        $pickUpAdrressModel = Parcel::getInstance()->pickUpAddressModel;

        return $this->render('update', [
            'model' => $model,
            'models' => array_combine($this->module->models,$this->module->models),
            'functions' => $model->getFunctions(),
            'pickUpAddress' => new $pickUpAdrressModel(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = ParcelModelMap::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Parcel::t('msg','no_page'));
    }

    public function actionSetDefault($id)
    {
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if ($model->load($post) && $model->update() !== false) {
                return $this->redirect(['index']);
            }
        }
        return $this->redirect(['index']);
    }

    public function actionGetData($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $mapModel = ParcelModelMap::findOne(['id' => $id]);
        $map = Json::decode($mapModel['map']);

        $data = [];

        $addressModel = $this->module->pickUpAddressModel::findOne(['id' => Yii::$app->request->get('address')]);

        $model = $mapModel->model::findOne(['id' => Yii::$app->request->get('modelID')]);

        foreach ($map as $className => $attributes) {
            if($className === 'PickupAddress') {
                foreach ($attributes as $key => $modelAttribute) {
                    $key = strtolower($key);
                    if($addressModel->hasAttribute($modelAttribute)) {
                        $data[strtolower($className) . "-$key"] = $addressModel->{$modelAttribute};
                    } else {
                        $data[strtolower($className) . "-$key"] = $modelAttribute;
                    }
                }
            } else {
                foreach ($attributes as $key => $modelAttribute) {
                    $key = strtolower($key);
                    if($model->hasAttribute($modelAttribute)) {
                        $data[strtolower($className) . "-$key"] = $model->{$modelAttribute};
                    } else {
                        $data[strtolower($className) . "-$key"] = $modelAttribute;
                    }
                }
            }
        }

        return ['success' => true,'values' => $data];
    }
}