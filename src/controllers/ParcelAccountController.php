<?php

namespace matejch\parcel\controllers;

use matejch\parcel\models\ParcelAccount;
use matejch\parcel\Parcel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/** @property Parcel $module */
class ParcelAccountController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' =>[
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','create','update','view','delete'],
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

    /**
     * Lists all SolverAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ParcelAccount::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new SolverAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ParcelAccount();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SolverAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SolverAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $model->delete();
        } catch (NotFoundHttpException | StaleObjectException $e) {
            Yii::$app->session->setFlash('danger',$e->getMessage());
            return $this->redirect(Yii::$app->request->referrer);
        }


        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the SolverAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParcelAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParcelAccount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Parcel::t('msg','no_page'));
    }
}