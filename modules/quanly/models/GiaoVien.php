<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\danhmuc\models\DmGioitinh;
use Yii;

/**
 * This is the model class for table "giao_vien".
 *
 * @property int $id
 * @property string|null $ma
 * @property string|null $ho_ten
 * @property string|null $cccd
 * @property string|null $so_dien_thoai
 * @property string|null $gmail
 * @property string|null $ngay_sinh
 * @property string|null $trinh_do
 * @property string|null $bang_cap
 * @property int|null $sogio_tuan
 * @property int|null $status
 * @property int|null $gioitinh_id
 *
 * @property DmGioitinh $gioitinh
 */
class GiaoVien extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'giao_vien';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma', 'ho_ten', 'cccd', 'so_dien_thoai', 'gmail', 'ngay_sinh', 'trinh_do', 'bang_cap', 'sogio_tuan', 'status', 'gioitinh_id'], 'default', 'value' => null],
            [['ma', 'ho_ten', 'cccd', 'so_dien_thoai', 'gmail', 'trinh_do', 'bang_cap'], 'string'],
            [['ngay_sinh'], 'safe'],
            [['sogio_tuan', 'status', 'gioitinh_id'], 'default', 'value' => null],
            [['sogio_tuan', 'status', 'gioitinh_id'], 'integer'],
            [['gioitinh_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmGioitinh::class, 'targetAttribute' => ['gioitinh_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma' => 'Mã giáo viên',
            'ho_ten' => 'Họ tên',
            'cccd' => 'Cccd',
            'so_dien_thoai' => 'Số Điện thoại',
            'gmail' => 'Gmail',
            'ngay_sinh' => 'Ngày sinh',
            'trinh_do' => 'Trình độ',
            'bang_cap' => 'Hồ sơ, Bằng cấp',
            'sogio_tuan' => 'Số giờ được dạy trên tuần',
            'status' => 'Status',
            'gioitinh_id' => 'Giới tính',
        ];
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

}
