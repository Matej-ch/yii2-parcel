<?php

namespace matejch\parcel\models;

use matejch\parcel\Parcel;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "parcel_shipment".
 *
 * @property int $id
 * @property string|null $function
 * @property string|null $model
 * @property int|null $model_id
 * @property string|null $data
 * @property string|null $response
 * @property int $handover_protocol_id
 * @property int $is_active
 * @property string $created_at
 * @property int $user_id
 */
class ParcelShipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parcel_shipment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model_id','handover_protocol_id','is_active'], 'integer'],
            [['data', 'response'], 'string'],
            [['function'], 'string', 'max' => 128],
            [['model'], 'string', 'max' => 256],
            [['handover_protocol_id'],'default','value'=>0],
            [['is_active'],'default','value'=>1],
            [['created_at'],'safe'],
            [['created_at'],'default','value'=>'0000-00-00'],
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if($insert) {
            $handoverProtocol = HandoverProtocol::find()->select('id')
                ->where(['is_closed' => HandoverProtocol::IS_OPEN,'type' => 'parcel','date'=>date('Y-m-d')])
                ->asArray()
                ->orderBy(['id'=>SORT_DESC])
                ->one();
            if(isset($handoverProtocol) && !empty($handoverProtocol)) {
                $this->handover_protocol_id = $handoverProtocol['id'];
            }
            $this->created_at = date('Y-m-d');
        }

        return true;
    }

    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'user_id',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['user_id'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Parcel::t('model', 'id'),
            'function' => Parcel::t('model', 'function'),
            'data' => Parcel::t('model', 'data'),
            'response' => Parcel::t('model', 'response'),
            'model' => Parcel::t('model', 'model'),
            'model_id' => 'Model ID',
            'handover_protocol_id' => Parcel::t('model','handover_protocol_id'),
            'is_active' => Parcel::t('model','is_active'),
            'created_at' => Parcel::t('model','created_at'),
        ];
    }

    public static function create($sequence,$result)
    {
        $shipment = new static();
        $shipment->function = $result->function;
        $shipment->model = $result->model ?? '';
        $shipment->model_id = $result->model_id ?? 0;
        $shipment->data = Json::encode($shipment->filterPrivateInfo($sequence));
        $shipment->response = Json::encode($result);
        $shipment->save();
    }

    private function filterPrivateInfo($sequence)
    {
        $privateAttributes = ['aPassword','password'];

        foreach ($privateAttributes as $privateAttribute) {
            if(property_exists($sequence,$privateAttribute)) {
                $sequence->{$privateAttribute} = '';
            }
        }

        return $sequence;
    }

    public function getParsedResponse()
    {
        $lookup = [
            'createAndPrintCifShipment' => CifCreateAndPrintResult::class,
            'createCifShipment' => CifCreateShipmentResult::class,
            'uploadMipShipments' => MipWebserviceUploadResult::class,
            'printEndOfDay' => WebServicePrintResult::class,
            'printShipmentLabels' => WebServicePrintResult::class,
            'createMipShipment' => WebServiceShipmentResult::class,
        ];

        $response = Json::decode($this->response);

        $resultClass = new $lookup[$response['function']]();
        $resultClass->load($response["{$response['function']}Return"],'');

        return $resultClass->toMessage();
    }

    public function getProtocol()
    {
        return $this->hasOne(HandoverProtocol::class,["id"=>"handover_protocol_id"]);
    }

    public function getAddressParsed(): string
    {
        $data = Json::decode($this->data);

        $html = '';
        if(isset($data['webServiceShipment']['deliveryaddress'])) {
            foreach ($data['webServiceShipment']['deliveryaddress'] as $field) {
                $html .= "<div>$field</div>";
            }
        }

        return $html;
    }

    public function changeValidState(): bool
    {
        $this->is_active = ($this->is_active === 1) ? 0 : 1;
        return $this->update(true,['is_active']) !== false;
    }

    public function removeFromProtocol(): bool
    {
        $this->handover_protocol_id = 0;
        return $this->update() !== false;
    }

    public static function handoverCod($handoverID): array
    {
        $shipments = self::find()->select('*')->where(['handover_protocol_id'=>$handoverID])->all();

        $codPrice = 0;
        $codCurrency = '';
        foreach ($shipments as $shipment) {
            $data = Json::decode($shipment->data);
            if(isset($data['webServiceShipment']['cod'])) {
                $codPrice += (float)$data['webServiceShipment']['cod']['codvalue'];
            }
        }

        return [$codPrice, $codCurrency];
    }
}
