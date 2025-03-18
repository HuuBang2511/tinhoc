<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\DiagioiHanhchinh;

/**
 * DiagioiHanhchinhSearch represents the model behind the search form about `app\modules\quanly\models\DiagioiHanhchinh`.
 */
class DiagioiHanhchinhSearch extends DiagioiHanhchinh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'geom', 'geom_text'], 'integer'],
            [['ma_diagioi_hanhchinh', 'ten'], 'safe'],
            [['tong_dientich'], 'number'],
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
        $query = DiagioiHanhchinh::find();

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
            'tong_dientich' => $this->tong_dientich,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'upper(ma_diagioi_hanhchinh)', mb_strtoupper($this->ma_diagioi_hanhchinh)])
            ->andFilterWhere(['like', 'upper(ten)', mb_strtoupper($this->ten)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'ma_diagioi_hanhchinh',
        'ten',
        'tong_dientich',
        'status',        ];
    }
}
