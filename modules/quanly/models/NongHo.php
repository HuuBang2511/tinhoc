<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\danhmuc\models\DmPhuongxa;

use Yii;

/**
 * This is the model class for table "nong_ho".
 *
 * @property int $id
 * @property string|null $geo_x
 * @property string|null $geo_y
 * @property string|null $geom
 * @property string|null $ma_nong_ho
 * @property string|null $chunongho_ten
 * @property int|null $phuongxa_id
 * @property string|null $so_nha
 * @property string|null $ten_duong
 * @property string|null $dia_chi
 * @property int|null $quanhuyen_id
 * @property int|null $tinhthanh_id
 * @property int|null $status
 * @property string|null $so_dien_thoai
 * @property string|null $url_hinhanh
 *
 * @property DienbienDichbenh[] $dienbienDichbenhs
 * @property DmPhuongxa $phuongxa
 */
class NongHo extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nong_ho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['geo_x', 'geo_y', 'geom', 'ma_nong_ho', 'chunongho_ten', 'so_nha', 'ten_duong', 'dia_chi', 'so_dien_thoai', 'url_hinhanh'], 'string'],
            [['phuongxa_id', 'quanhuyen_id', 'tinhthanh_id', 'status'], 'default', 'value' => null],
            [['phuongxa_id', 'quanhuyen_id', 'tinhthanh_id', 'status'], 'integer'],
            [['phuongxa_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmPhuongxa::class, 'targetAttribute' => ['phuongxa_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'geo_x' => 'Geo X',
            'geo_y' => 'Geo Y',
            'geom' => 'Geom',
            'ma_nong_ho' => 'Mã Nông hộ',
            'chunongho_ten' => 'Tên chủ nông hộ',
            'phuongxa_id' => 'Phường xã',
            'so_nha' => 'Số nhà',
            'ten_duong' => 'Tên đường',
            'dia_chi' => 'Địa chỉ',
            'quanhuyen_id' => 'Quận huyện',
            'tinhthanh_id' => 'Tỉnh thành',
            'status' => 'Status',
            'so_dien_thoai' => 'Số điện thoại',
            'url_hinhanh' => 'Url hình ảnh',
        ];
    }

    /**
     * Gets query for [[DienbienDichbenhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDienbienDichbenhs()
    {
        return $this->hasMany(DienbienDichbenh::class, ['nongho_id' => 'id']);
    }

    /**
     * Gets query for [[Phuongxa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhuongxa()
    {
        return $this->hasOne(DmPhuongxa::class, ['id' => 'phuongxa_id']);
    }
}
