<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;

use Yii;

/**
 * This is the model class for table "loai_cay_trong".
 *
 * @property int $id
 * @property string|null $ten Tên loại cây trồng
 * @property string|null $ghi_chu
 * @property int|null $status
 *
 * @property CaytrongCanhtac[] $caytrongCanhtacs
 * @property DienbienDichbenh[] $dienbienDichbenhs
 * @property ThongTinBenh[] $thongTinBenhs
 */
class LoaiCayTrong extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'loai_cay_trong';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'ghi_chu'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên Loại cây trồng',
            'ghi_chu' => 'Ghi chú',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[CaytrongCanhtacs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaytrongCanhtacs()
    {
        return $this->hasMany(CaytrongCanhtac::class, ['loaicaytrong_id' => 'id']);
    }

    /**
     * Gets query for [[DienbienDichbenhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDienbienDichbenhs()
    {
        return $this->hasMany(DienbienDichbenh::class, ['loaicaytrong_id' => 'id']);
    }

    /**
     * Gets query for [[ThongTinBenhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThongTinBenhs()
    {
        return $this->hasMany(ThongTinBenh::class, ['loaicaytrong_id' => 'id']);
    }
}
