<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\KhoaHoc;

/**
 * KhoaHocSearch represents the model behind the search form about `app\modules\quanly\models\KhoaHoc`.
 */
class KhoaHocSearch extends KhoaHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hocphi', 'trinhdo_id', 'status'], 'integer'],
            [['ma', 'ten', 'thoigian_khoahoc'], 'safe'],
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
        $query = KhoaHoc::find()->where(['status' => 1]);

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
            'hocphi' => $this->hocphi,
            'trinhdo_id' => $this->trinhdo_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'upper(ma)', mb_strtoupper($this->ma)])
            ->andFilterWhere(['like', 'upper(ten)', mb_strtoupper($this->ten)])
            ->andFilterWhere(['like', 'upper(thoigian_khoahoc)', mb_strtoupper($this->thoigian_khoahoc)]);

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
        'ten',
        'hocphi',
        'thoigian_khoahoc',
        'trinhdo_id',
        'status',        ];
    }
}
