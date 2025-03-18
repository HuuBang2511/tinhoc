<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\danhmuc\models\DmPhuongxa;
use app\modules\danhmuc\models\DmThuocbaove;

use Yii;

/**
 * This is the model class for table "cuahang_thuocbaove".
 *
 * @property int $id
 * @property string|null $ten_cua_hang
 * @property int|null $phuongxa_id
 * @property string|null $so_nha
 * @property string|null $ten_duong
 * @property string|null $dia_chi
 * @property int|null $status
 * @property int|null $thuocbaove_id
 * @property string|null $thuoc_bao_ve
 * @property int|null $quanhuyen_id
 * @property int|null $tinhthanh_id
 * @property string|null $geo_x
 * @property string|null $geo_y
 * @property string|null $geom
 * @property string|null $url_hinhanh
 *
 * @property DmPhuongxa $phuongxa
 * @property DmThuocbaove $thuocbaove
 */
class CuahangThuocbaove extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuahang_thuocbaove';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten_cua_hang', 'so_nha', 'ten_duong', 'dia_chi','geo_x', 'geo_y', 'geom', 'url_hinhanh'], 'string'],
            [['phuongxa_id', 'status', 'thuocbaove_id', 'quanhuyen_id', 'tinhthanh_id'], 'default', 'value' => null],
            [['thuoc_bao_ve'], 'safe'],
            [['phuongxa_id', 'status', 'thuocbaove_id', 'quanhuyen_id', 'tinhthanh_id'], 'integer'],
            [['phuongxa_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmPhuongxa::class, 'targetAttribute' => ['phuongxa_id' => 'id']],
            [['thuocbaove_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmThuocbaove::class, 'targetAttribute' => ['thuocbaove_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_cua_hang' => 'Tên cửa hàng',
            'phuongxa_id' => 'Phường xã',
            'so_nha' => 'Số nhà',
            'ten_duong' => 'Tên đường',
            'dia_chi' => 'Địa chỉ',
            'status' => 'Status',
            'thuocbaove_id' => 'Thuốc bảo vệ',
            'thuoc_bao_ve' => 'Thuốc bảo vệ',
            'quanhuyen_id' => 'Quận huyện',
            'tinhthanh_id' => 'Tỉnh thành',
            'geo_x' => 'Geo X',
            'geo_y' => 'Geo Y',
            'geom' => 'Geom',
            'url_hinhanh' => 'Hình ảnh',
        ];
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

    /**
     * Gets query for [[Thuocbaove]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThuocbaove()
    {
        return $this->hasOne(DmThuocbaove::class, ['id' => 'thuocbaove_id']);
    }
}
