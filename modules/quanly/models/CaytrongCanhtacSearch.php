<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\CaytrongCanhtac;

/**
 * CaytrongCanhtacSearch represents the model behind the search form about `app\modules\quanly\models\CaytrongCanhtac`.
 */
class CaytrongCanhtacSearch extends CaytrongCanhtac
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'loaicaytrong_id', 'status', 'diagioihanhchinh_id', 'ten_vung'], 'integer'],
            [['dien_tich'], 'number'],
            [['geom', 'geom_text'], 'safe'],
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
        $query = CaytrongCanhtac::find();

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
            'dien_tich' => $this->dien_tich,
            'status' => $this->status,
            'diagioihanhchinh_id' => $this->diagioihanhchinh_id,
        ]);

        $query->andFilterWhere(['like', 'upper(geom)', mb_strtoupper($this->geom)])
            ->andFilterWhere(['like', 'upper(geom_text)', mb_strtoupper($this->geom_text)])
            ->andFilterWhere(['like', 'upper(ten_vung)', mb_strtoupper($this->ten_vung)]);

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
        'dien_tich',
        'status',
        'geom',
        'geom_text',
        'diagioihanhchinh_id',        ];
    }
}
