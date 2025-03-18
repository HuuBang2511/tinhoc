<?php

namespace app\modules\danhmuc\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\danhmuc\models\DmThuocbaove;

/**
 * DmThuocbaoveSearch represents the model behind the search form about `app\modules\danhmuc\models\DmThuocbaove`.
 */
class DmThuocbaoveSearch extends DmThuocbaove
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['ten', 'ghi_chu', 'dac_tri', 'thanh_phan', 'dang_thuoc', 'quytac_donggoi', 'url_hinhanh'], 'safe'],
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
        $query = DmThuocbaove::find();

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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'upper(ten)', mb_strtoupper($this->ten)])
            ->andFilterWhere(['like', 'upper(ghi_chu)', mb_strtoupper($this->ghi_chu)])
            ->andFilterWhere(['like', 'upper(dac_tri)', mb_strtoupper($this->dac_tri)])
            ->andFilterWhere(['like', 'upper(thanh_phan)', mb_strtoupper($this->thanh_phan)])
            ->andFilterWhere(['like', 'upper(dang_thuoc)', mb_strtoupper($this->dang_thuoc)])
            ->andFilterWhere(['like', 'upper(quytac_donggoi)', mb_strtoupper($this->quytac_donggoi)])
            ->andFilterWhere(['like', 'upper(url_hinhanh)', mb_strtoupper($this->url_hinhanh)]);

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
        'ghi_chu',
        'status',
        'dac_tri',
        'thanh_phan',
        'dang_thuoc',
        'quytac_donggoi',
        'url_hinhanh',        ];
    }
}
