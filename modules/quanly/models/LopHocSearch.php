<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\LopHoc;

/**
 * LopHocSearch represents the model behind the search form about `app\modules\quanly\models\LopHoc`.
 */
class LopHocSearch extends LopHoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tinhtranglophoc_id', 'khoahoc_id', 'status'], 'integer'],
            [['ma', 'ngaybatdau', 'ngayketthuc'], 'safe'],
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
        $query = LopHoc::find()->where(['status' => 1]);

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
            'tinhtranglophoc_id' => $this->tinhtranglophoc_id,
            'khoahoc_id' => $this->khoahoc_id,
            'status' => $this->status,
            'ngaybatdau' => $this->ngaybatdau,
            'ngayketthuc' => $this->ngayketthuc,
        ]);

        $query->andFilterWhere(['like', 'upper(ma)', mb_strtoupper($this->ma)]);

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
        'tinhtranglophoc_id',
        'khoahoc_id',
        'status',
        'ngaybatdau',
        'ngayketthuc',        ];
    }
}
