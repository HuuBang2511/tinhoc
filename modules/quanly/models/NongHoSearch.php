<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\NongHo;

/**
 * NongHoSearch represents the model behind the search form about `app\modules\quanly\models\NongHo`.
 */
class NongHoSearch extends NongHo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'phuongxa_id', 'quanhuyen_id', 'tinhthanh_id'], 'integer'],
            [['geo_x', 'geo_y', 'geom', 'ma_nong_ho', 'chunongho_ten', 'so_nha', 'ten_duong', 'dia_chi', 'status'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NongHo::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'phuongxa_id' => $this->phuongxa_id,
            'quanhuyen_id' => $this->quanhuyen_id,
            'tinhthanh_id' => $this->tinhthanh_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'upper(geo_x)', mb_strtoupper($this->geo_x)])
            ->andFilterWhere(['like', 'upper(geo_y)', mb_strtoupper($this->geo_y)])
            ->andFilterWhere(['like', 'upper(geom)', mb_strtoupper($this->geom)])
            ->andFilterWhere(['like', 'upper(ma_nong_ho)', mb_strtoupper($this->ma_nong_ho)])
            ->andFilterWhere(['like', 'upper(chunongho_ten)', mb_strtoupper($this->chunongho_ten)])
            ->andFilterWhere(['like', 'upper(so_nha)', mb_strtoupper($this->so_nha)])
            ->andFilterWhere(['like', 'upper(ten_duong)', mb_strtoupper($this->ten_duong)])
            ->andFilterWhere(['like', 'upper(dia_chi)', mb_strtoupper($this->dia_chi)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'geo_x',
        'geo_y',
        'geom',
        'ma_nong_ho',
        'chunongho_ten',
        'phuongxa_id',
        'so_nha',
        'ten_duong',
        'dia_chi',
        'quanhuyen_id',
        'tinhthanh_id',        ];
    }
}
