<?php


namespace matejch\parcel\widget;


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

        if(!isset($this->model)) {
            throw new InvalidConfigException(Yii::t('msg', 'Please specify the "model" property in widget.'));
        }

        if(!isset($this->function)) {
            throw new InvalidConfigException(Yii::t('msg', 'Please specify the "function" property in widget.'));
        }

        if(!in_array(get_class($this->model),Yii::$app->getModule('parcel')->models)) {
            throw new InvalidConfigException(Yii::t('msg', 'Please specify the VALID "model" in widget.'));
        }
    }

    public function run()
    {
        parent::run();

        $maps = ParcelModelMap::find()
            ->where(['function' => $this->function,'model' => get_class($this->model)])
            ->orderBy(['default' => SORT_DESC])
            ->all();

        $account = ParcelAccount::findDefault();
        if(!$account) {
            return Yii::t('msg', 'account_not_found');
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
}