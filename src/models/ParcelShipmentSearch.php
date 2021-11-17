<?php


namespace matejch\parcel\models;


use yii\base\Model;
use yii\data\ActiveDataProvider;

class ParcelShipmentSearch extends ParcelShipment
{
    public function rules()
    {
        return [
            [['id', 'model_id','handover_protocol_id','is_active','model_id'], 'integer'],
            [['model','data','response'], 'string'],
            [['created_at'],'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params,$id = null, $view = 'index')
    {
        $query = ParcelShipment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $handover = ['handover_protocol_id' => $this->handover_protocol_id];
        if($view === 'create') {
            $handover = ['handover_protocol_id' => 0];
        }
        if($view === 'view') {
            $handover = ['handover_protocol_id' => $id];
        }

        $query->andFilterWhere(array_merge(['id' => $this->id, 'model_id' => $this->model_id,'is_active' => $this->is_active],$handover));

        $query->andFilterWhere(['like', 'model', $this->model]);
        $query->andFilterWhere(['like', 'response', $this->response]);
        $query->andFilterWhere(['like', 'created_at', $this->created_at]);
        return $dataProvider;
    }
}