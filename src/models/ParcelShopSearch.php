<?php

namespace matejch\parcel\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ParcelShopSearch extends ParcelShop
{
    public function rules()
    {
        return [
            [['id', 'status', 'center'], 'integer'],
            [['type', 'place_id', 'description', 'address', 'city', 'zip', 'virtualzip', 'countryISO', 'gps', 'workDays'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = ParcelShop::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'center' => $this->center,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'place_id', $this->place_id])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'virtualzip', $this->virtualzip])
            ->andFilterWhere(['like', 'countryISO', $this->countryISO])
            ->andFilterWhere(['like', 'gps', $this->gps])
            ->andFilterWhere(['like', 'workDays', $this->workDays]);

        return $dataProvider;
    }
}