<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\KyThi;

/**
 * KyThiSearch represents the model behind the search form about `app\modules\quanly\models\KyThi`.
 */
class KyThiSearch extends KyThi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lophoc_id', 'status'], 'integer'],
            [['ngay_thi', 'sochungnhan', 'sophoibang'], 'safe'],
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
        $query = KyThi::find()->where(['status' => 1]);

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
            'ngay_thi' => $this->ngay_thi,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'upper(sochungnhan)', mb_strtoupper($this->sochungnhan)])
            ->andFilterWhere(['like', 'upper(sophoibang)', mb_strtoupper($this->sophoibang)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'lophoc_id',
        'ngay_thi',
        'status',
        'sochungnhan',
        'sophoibang',        ];
    }
}
