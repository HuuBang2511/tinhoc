<?php

namespace app\modules\quanly\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\quanly\models\Lichhoc;

/**
 * LichhocSearch represents the model behind the search form about `app\modules\quanly\models\Lichhoc`.
 */
class LichhocSearch extends Lichhoc
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'lophoc_id', 'giaovien_id', 'thutrongtuan', 'status', 'phonghoc_id'], 'integer'],
            [['giobatdau', 'gioketthuc'], 'number'],
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
        $query = Lichhoc::find()->where(['status' => 1]);

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
            'giaovien_id' => $this->giaovien_id,
            'giobatdau' => $this->giobatdau,
            'gioketthuc' => $this->gioketthuc,
            'thutrongtuan' => $this->thutrongtuan,
            'status' => $this->status,
            'phonghoc_id' => $this->phonghoc_id,
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
        'lophoc_id',
        'giaovien_id',
        'giobatdau',
        'gioketthuc',
        'thutrongtuan',
        'status',
        'phonghoc_id',        ];
    }
}
