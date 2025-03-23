<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\KhoaHoc;
use app\modules\danhmuc\models\DmTinhtranglophoc;
use Yii;

/**
 * This is the model class for table "lop_hoc".
 *
 * @property int $id
 * @property string|null $ma
 * @property int|null $tinhtranglophoc_id
 * @property int|null $khoahoc_id
 * @property int|null $status
 * @property string|null $ngaybatdau
 * @property string|null $ngayketthuc
 *
 * @property DiemDanh[] $diemDanhs
 * @property HocvienLophoc[] $hocvienLophocs
 * @property KhoaHoc $khoahoc
 * @property DmTinhtranglophoc $tinhtranglophoc
 */
class LopHoc extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lop_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma', 'tinhtranglophoc_id', 'khoahoc_id', 'status', 'ngaybatdau', 'ngayketthuc'], 'default', 'value' => null],
            [['ma'], 'string'],
            [['tinhtranglophoc_id', 'khoahoc_id', 'status'], 'default', 'value' => null],
            [['tinhtranglophoc_id', 'khoahoc_id', 'status'], 'integer'],
            [['ngaybatdau', 'ngayketthuc'], 'safe'],
            [['tinhtranglophoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTinhtranglophoc::class, 'targetAttribute' => ['tinhtranglophoc_id' => 'id']],
            [['khoahoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => KhoaHoc::class, 'targetAttribute' => ['khoahoc_id' => 'id']],
            [['ma', 'tinhtranglophoc_id', 'khoahoc_id'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma' => 'Mã lớp học',
            'tinhtranglophoc_id' => 'Tình trạng lớp học',
            'khoahoc_id' => 'Khóa học',
            'status' => 'Status',
            'ngaybatdau' => 'Ngày bắt đầu',
            'ngayketthuc' => 'Ngày kết thúc',
        ];
    }

    /**
     * Gets query for [[DiemDanhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiemDanhs()
    {
        return $this->hasMany(DiemDanh::class, ['lophoc_id' => 'id']);
    }

    /**
     * Gets query for [[HocvienLophocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocvienLophocs()
    {
        return $this->hasMany(HocvienLophoc::class, ['lophoc_id' => 'id']);
    }

    /**
     * Gets query for [[Khoahoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoahoc()
    {
        return $this->hasOne(KhoaHoc::class, ['id' => 'khoahoc_id']);
    }

    /**
     * Gets query for [[Tinhtranglophoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTinhtranglophoc()
    {
        return $this->hasOne(DmTinhtranglophoc::class, ['id' => 'tinhtranglophoc_id']);
    }

}
