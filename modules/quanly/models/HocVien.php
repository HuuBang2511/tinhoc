<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\danhmuc\models\DmGioitinh;
use app\modules\danhmuc\models\DmTrinhdo;
use Yii;

/**
 * This is the model class for table "hoc_vien".
 *
 * @property int $id
 * @property string|null $ma
 * @property int|null $lophoc_id
 * @property string|null $so_dien_thoai
 * @property string|null $gmail
 * @property int|null $gioitinh_id
 * @property string|null $ngay_sinh
 * @property string|null $cccd
 * @property int|null $status
 * @property string|null $ho_ten
 * @property bool|null $baoluuketqua
 * @property int|null $trinhdo_id
 *
 * @property DiemDanh[] $diemDanhs
 * @property DmGioitinh $gioitinh
 * @property HocvienLophoc[] $hocvienLophocs
 * @property DmTrinhdo $trinhdo
 */
class HocVien extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hoc_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma', 'lophoc_id', 'so_dien_thoai', 'gmail', 'gioitinh_id', 'ngay_sinh', 'cccd', 'status', 'ho_ten', 'baoluuketqua', 'trinhdo_id'], 'default', 'value' => null],
            [['ma', 'so_dien_thoai', 'gmail', 'cccd', 'ho_ten'], 'string'],
            [['lophoc_id', 'gioitinh_id', 'status', 'trinhdo_id'], 'default', 'value' => null],
            [['lophoc_id', 'gioitinh_id', 'status', 'trinhdo_id'], 'integer'],
            [['ngay_sinh'], 'safe'],
            [['baoluuketqua'], 'boolean'],
            [['gioitinh_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmGioitinh::class, 'targetAttribute' => ['gioitinh_id' => 'id']],
            [['trinhdo_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTrinhdo::class, 'targetAttribute' => ['trinhdo_id' => 'id']],
            [['ma', 'ho_ten'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
           'ma' => 'Mã học viên',
            'lophoc_id' => 'Lophoc ID',
            'so_dien_thoai' => 'Số điện thoại',
            'gmail' => 'Gmail',
            'gioitinh_id' => 'Giới tính',
            'ngay_sinh' => 'Ngày sinh',
            'cccd' => 'CCCD',
            'status' => 'Status',
            'ho_ten' => 'Họ tên',
            'baoluuketqua' => 'Bảo lưu kết quả',
            'trinhdo_id' => 'Trình độ',
        ];
    }

    /**
     * Gets query for [[DiemDanhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiemDanhs()
    {
        return $this->hasMany(DiemDanh::class, ['hocvien_id' => 'id']);
    }

    /**
     * Gets query for [[Gioitinh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGioitinh()
    {
        return $this->hasOne(DmGioitinh::class, ['id' => 'gioitinh_id']);
    }

    /**
     * Gets query for [[HocvienLophocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocvienLophocs()
    {
        return $this->hasMany(HocvienLophoc::class, ['hocvien_id' => 'id']);
    }

    /**
     * Gets query for [[Trinhdo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrinhdo()
    {
        return $this->hasOne(DmTrinhdo::class, ['id' => 'trinhdo_id']);
    }

}
