<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\ThuChi;

/**
 * ThuChiSearch represents the model behind the search form about `app\modules\quanly\models\ThuChi`.
 */
class ThuChiSearch extends ThuChi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tinhtrangtien', 'status'], 'integer'],
            [['sotien'], 'number'],
            [['thongtin', 'ngay'], 'safe'],
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
        $query = ThuChi::find()->where(['status' => 1]);

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
            'sotien' => $this->sotien,
            'tinhtrangtien' => $this->tinhtrangtien,
            'status' => $this->status,
            'ngay' => $this->ngay,
        ]);

        $query->andFilterWhere(['like', 'upper(thongtin)', mb_strtoupper($this->thongtin)]);

        return $dataProvider;
    }

    public function getExportColumns()
    {
        return [
            [
                'class' => 'kartik\grid\SerialColumn',
            ],
            'id',
        'sotien',
        'tinhtrangtien',
        'thongtin',
        'status',
        'ngay',        ];
    }
}
