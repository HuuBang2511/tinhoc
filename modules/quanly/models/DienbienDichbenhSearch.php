<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\DienbienDichbenh;

/**
 * DienbienDichbenhSearch represents the model behind the search form about `app\modules\quanly\models\DienbienDichbenh`.
 */
class DienbienDichbenhSearch extends DienbienDichbenh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'loaicaytrong_id', 'thongtinbenh_id', 'nongho_id', 'status', 'caytrongcanhtac_id'], 'integer'],
            [['dientich_nhiembenh'], 'number'],
            [['thoi_diem'], 'safe'],
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
        $query = DienbienDichbenh::find();

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
            'loaicaytrong_id' => $this->loaicaytrong_id,
            'thongtinbenh_id' => $this->thongtinbenh_id,
            'nongho_id' => $this->nongho_id,
            'dientich_nhiembenh' => $this->dientich_nhiembenh,
            'status' => $this->status,
            'caytrongcanhtac_id' => $this->caytrongcanhtac_id,
        ]);

        $query->andFilterWhere(['like', 'upper(thoi_diem)', mb_strtoupper($this->thoi_diem)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'loaicaytrong_id',
        'thongtinbenh_id',
        'nongho_id',
        'dientich_nhiembenh',
        'thoi_diem',
        'status',
        'caytrongcanhtac_id',        ];
    }
}
