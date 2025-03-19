<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\HocVien;

/**
 * HocVienSearch represents the model behind the search form about `app\modules\quanly\models\HocVien`.
 */
class HocVienSearch extends HocVien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lophoc_id', 'gioitinh_id', 'status'], 'integer'],
            [['ma', 'so_dien_thoai', 'gmail', 'ngay_sinh', 'cccd', 'ho_ten'], 'safe'],
            [['baoluuketqua'], 'boolean'],
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
        $query = HocVien::find()->where(['status' => 1]);

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
            'lophoc_id' => $this->lophoc_id,
            'gioitinh_id' => $this->gioitinh_id,
            'ngay_sinh' => $this->ngay_sinh,
            'status' => $this->status,
            'baoluuketqua' => $this->baoluuketqua,
        ]);

        $query->andFilterWhere(['like', 'upper(ma)', mb_strtoupper($this->ma)])
            ->andFilterWhere(['like', 'upper(so_dien_thoai)', mb_strtoupper($this->so_dien_thoai)])
            ->andFilterWhere(['like', 'upper(gmail)', mb_strtoupper($this->gmail)])
            ->andFilterWhere(['like', 'upper(cccd)', mb_strtoupper($this->cccd)])
            ->andFilterWhere(['like', 'upper(ho_ten)', mb_strtoupper($this->ho_ten)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'ma',
        'lophoc_id',
        'so_dien_thoai',
        'gmail',
        'gioitinh_id',
        'ngay_sinh',
        'cccd',
        'status',
        'ho_ten',
        'baoluuketqua',        ];
    }
}
