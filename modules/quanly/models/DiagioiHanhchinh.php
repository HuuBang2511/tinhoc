<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use Yii;

/**
 * This is the model class for table "diagioi_hanhchinh".
 *
 * @property int $id
 * @property string|null $ma_diagioi_hanhchinh
 * @property string|null $ten
 * @property float|null $tong_dientich
 * @property int|null $status
 * @property string|null $geom
 * @property string|null $geom_text
 *
 * @property CaytrongCanhtac[] $caytrongCanhtacs
 */
class DiagioiHanhchinh extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diagioi_hanhchinh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma_diagioi_hanhchinh', 'ten', 'geom', 'geom_text'], 'string'],
            //[['tong_dientich'], 'number'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['tong_dientich'], 'match', 'pattern' => '/^([0-9.,])+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma_diagioi_hanhchinh' => 'Mã địa giới hành chính',
            'ten' => 'Tên',
            'tong_dientich' => 'Tổng diện tích',
            'status' => 'Status',
            'geom' => 'Geom',
            'geom_text' => 'Geom Text',
        ];
    }

    /**
     * Gets query for [[CaytrongCanhtacs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaytrongCanhtacs()
    {
        return $this->hasMany(CaytrongCanhtac::class, ['diagioihanhchinh_id' => 'id']);
    }
}
