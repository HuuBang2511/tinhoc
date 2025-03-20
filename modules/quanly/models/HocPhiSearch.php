<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\HocPhi;

/**
 * HocPhiSearch represents the model behind the search form about `app\modules\quanly\models\HocPhi`.
 */
class HocPhiSearch extends HocPhi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'hocvien_id', 'lophoc_id', 'status'], 'integer'],
            [['sotien'], 'number'],
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
        $query = HocPhi::find()->where(['status' => 1]);

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
            'sotien' => $this->sotien,
            'status' => $this->status,
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
        'sotien',
        'status',        ];
    }
}
