<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\CuahangThuocbaove;

/**
 * CuahangThuocbaoveSearch represents the model behind the search form about `app\modules\quanly\models\CuahangThuocbaove`.
 */
class CuahangThuocbaoveSearch extends CuahangThuocbaove
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'phuongxa_id', 'status', 'thuocbaove_id', 'quanhuyen_id', 'tinhthanh_id'], 'integer'],
            [['ten_cua_hang', 'so_nha', 'ten_duong', 'dia_chi', 'thuoc_bao_ve'], 'safe'],
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
        $query = CuahangThuocbaove::find();

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
            'status' => $this->status,
            'thuocbaove_id' => $this->thuocbaove_id,
            'quanhuyen_id' => $this->quanhuyen_id,
            'tinhthanh_id' => $this->tinhthanh_id,
        ]);

        $query->andFilterWhere(['like', 'upper(ten_cua_hang)', mb_strtoupper($this->ten_cua_hang)])
            ->andFilterWhere(['like', 'upper(so_nha)', mb_strtoupper($this->so_nha)])
            ->andFilterWhere(['like', 'upper(ten_duong)', mb_strtoupper($this->ten_duong)])
            ->andFilterWhere(['like', 'upper(dia_chi)', mb_strtoupper($this->dia_chi)])
            ->andFilterWhere(['like', 'upper(thuoc_bao_ve)', mb_strtoupper($this->thuoc_bao_ve)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'ten_cua_hang',
        'phuongxa_id',
        'so_nha',
        'ten_duong',
        'dia_chi',
        'status',
        'thuocbaove_id',
        'thuoc_bao_ve',
        'quanhuyen_id',
        'tinhthanh_id',        ];
    }
}
