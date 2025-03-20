<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\HocvienLophoc;

/**
 * HocvienLophocSearch represents the model behind the search form about `app\modules\quanly\models\HocvienLophoc`.
 */
class HocvienLophocSearch extends HocvienLophoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hocvien_id', 'lophoc_id', 'status', 'tinhtranghocphi_id', 'tinhtranghoanthanh_id'], 'integer'],
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
        $query = HocvienLophoc::find();

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
            'hocvien_id' => $this->hocvien_id,
            'lophoc_id' => $this->lophoc_id,
            'status' => $this->status,
            'tinhtranghocphi_id' => $this->tinhtranghocphi_id,
            'tinhtranghoanthanh_id' => $this->tinhtranghoanthanh_id,
        ]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'hocvien_id',
        'lophoc_id',
        'status',
        'tinhtranghocphi_id',
        'tinhtranghoanthanh_id',        ];
    }
}
