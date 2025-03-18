<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\ThongTinBenh;

/**
 * ThongTinBenhSearch represents the model behind the search form about `app\modules\quanly\models\ThongTinBenh`.
 */
class ThongTinBenhSearch extends ThongTinBenh
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'loaicaytrong_id', 'status', 'thuocbaove_id'], 'integer'],
            [['ten', 'thongtin_benh', 'thuoc_bao_ve'], 'safe'],
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
        $query = ThongTinBenh::find();

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
            'status' => $this->status,
            'thuocbaove_id' => $this->thuocbaove_id,
        ]);

        $query->andFilterWhere(['like', 'upper(ten)', mb_strtoupper($this->ten)])
            ->andFilterWhere(['like', 'upper(thongtin_benh)', mb_strtoupper($this->thongtin_benh)])
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
        'ten',
        'loaicaytrong_id',
        'thongtin_benh',
        'status',
        'thuocbaove_id',
        'thuoc_bao_ve',        ];
    }
}
