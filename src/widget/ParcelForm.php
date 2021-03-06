<?php


namespace matejch\parcel\widget;


use matejch\parcel\assets\ParcelFormAsset;
use matejch\parcel\models\Cod;
use matejch\parcel\models\ParcelAccount;
use matejch\parcel\models\ParcelModelMap;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class ParcelForm extends Widget
{

    /** @var boolean $isCzech */
    public $isCzech = false;

    /** @var boolean $isSaturday */
    public $isSaturday = false;

    /** @var boolean $isCod */
    public $isCod = false;

    /** @var float|string $price */
    public $price = null;

    /** @var string $function */
    public $function;

    public $model;

    public $pickupAddress = null;

    /** @var array $formAction */
    public $formAction = [];

    public $rbacColumnRules;

    public function init()
    {
        parent::init();

        \Yii::setAlias('@matejch/parcel',__DIR__. '/..');

        $this->registerTranslations();

        if(!isset($this->model)) {
            throw new InvalidConfigException(Yii::t('parcel/msg', 'Please specify the "model" property in widget.'));
        }

        if(!isset($this->function)) {
            throw new InvalidConfigException(Yii::t('parcel/msg', 'Please specify the "function" property in widget.'));
        }

        if(!in_array(get_class($this->model), Yii::$app->getModule('parcel')->models, true)) {
            throw new InvalidConfigException(Yii::t('parcel/msg', 'Please specify the VALID "model" in widget.'));
        }
    }

    public function run()
    {
        parent::run();

        $view = $this->getView();

        /** it goes to js */
        $btnMsg = Yii::t('parcel/msg','send_btn',['name' => '']);

        ParcelFormAsset::register($view);

        $maps = ParcelModelMap::find()
            ->where(['function' => $this->function,'model' => get_class($this->model)])
            ->orderBy(['default' => SORT_DESC])
            ->all();

        $account = ParcelAccount::findDefault();
        if(!$account) {
            return Yii::t('parcel/msg', 'account_not_found');
        }

        $forms = ParcelModelMap::cifShipmentMap();

        if(!$this->isCod) {
            unset($forms[(new Cod())->getClassName()]);
        }

        if($this->pickupAddress) {
            $pickUpAddrModel = $this->pickupAddress;
        } else {
            $pickUpAddrModel = Yii::$app->getModule('parcel')->pickUpAddressModel::findOne(['id' => 1]);
        }

        $addresses = Yii::$app->getModule('parcel')->pickUpAddressModel::find()
            ->select(['id','meno'])->orderBy(['id' => SORT_ASC])->asArray()->all();

        return $this->render('_form',[
            'formAction' => $this->formAction,
            'isCzech' => $this->isCzech,
            'isSaturday' => $this->isSaturday,
            'isCod' => $this->isCod,
            'price' => $this->price,
            'maps' => $maps,
            'account' => $account,
            'forms' => $forms,
            'model' => $this->model,
            'pickUpAddressModel' => $pickUpAddrModel,
            'addresses' => $addresses,
            'accounts' => ParcelAccount::find()->select(['id','name'])->orderBy(['default' => SORT_DESC])->all(),
            'rbacColumnRules' => $this->rbacColumnRules
        ]);
    }

    public function registerTranslations()
    {
        if (Yii::$app->has('i18n')) {
            Yii::$app->i18n->translations['parcel/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
                'basePath' => '@matejch/parcel/messages',
                'fileMap' => [
                    'parcel/msg' => 'msg.php',
                    'parcel/model' => 'model.php',
                ],
            ];
        }
    }
}