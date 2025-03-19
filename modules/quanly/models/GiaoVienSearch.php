<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\GiaoVien;

/**
 * GiaoVienSearch represents the model behind the search form about `app\modules\quanly\models\GiaoVien`.
 */
class GiaoVienSearch extends GiaoVien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sogio_tuan', 'status', 'gioitinh_id'], 'integer'],
            [['ma', 'ho_ten', 'cccd', 'so_dien_thoai', 'gmail', 'ngay_sinh', 'trinh_do', 'bang_cap'], 'safe'],
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
        $query = GiaoVien::find()->where(['status' => 1]);

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
            'ngay_sinh' => $this->ngay_sinh,
            'sogio_tuan' => $this->sogio_tuan,
            'status' => $this->status,
            'gioitinh_id' => $this->gioitinh_id,
        ]);

        $query->andFilterWhere(['like', 'upper(ma)', mb_strtoupper($this->ma)])
            ->andFilterWhere(['like', 'upper(ho_ten)', mb_strtoupper($this->ho_ten)])
            ->andFilterWhere(['like', 'upper(cccd)', mb_strtoupper($this->cccd)])
            ->andFilterWhere(['like', 'upper(so_dien_thoai)', mb_strtoupper($this->so_dien_thoai)])
            ->andFilterWhere(['like', 'upper(gmail)', mb_strtoupper($this->gmail)])
            ->andFilterWhere(['like', 'upper(trinh_do)', mb_strtoupper($this->trinh_do)])
            ->andFilterWhere(['like', 'upper(bang_cap)', mb_strtoupper($this->bang_cap)]);

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
        'ho_ten',
        'cccd',
        'so_dien_thoai',
        'gmail',
        'ngay_sinh',
        'trinh_do',
        'bang_cap',
        'sogio_tuan',
        'status',
        'gioitinh_id',        ];
    }
}
