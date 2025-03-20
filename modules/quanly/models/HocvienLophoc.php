<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\HocVien;
use app\modules\quanly\models\LopHoc;
use app\modules\danhmuc\models\DmTinhtranghocphi;
use app\modules\danhmuc\models\DmTinhtranghoanthanh;

use Yii;

/**
 * This is the model class for table "hocvien_lophoc".
 *
 * @property int $id
 * @property int|null $hocvien_id
 * @property int|null $lophoc_id
 * @property int|null $status
 * @property int|null $tinhtranghocphi_id
 * @property int|null $tinhtranghoanthanh_id
 *
 * @property HocVien $hocvien
 * @property LopHoc $lophoc
 * @property DmTinhtranghoanthanh $tinhtranghoanthanh
 * @property DmTinhtranghocphi $tinhtranghocphi
 */
class HocvienLophoc extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hocvien_lophoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hocvien_id', 'lophoc_id', 'status', 'tinhtranghocphi_id', 'tinhtranghoanthanh_id'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status', 'tinhtranghocphi_id', 'tinhtranghoanthanh_id'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status', 'tinhtranghocphi_id', 'tinhtranghoanthanh_id'], 'integer'],
            [['tinhtranghoanthanh_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTinhtranghoanthanh::class, 'targetAttribute' => ['tinhtranghoanthanh_id' => 'id']],
            [['tinhtranghocphi_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTinhtranghocphi::class, 'targetAttribute' => ['tinhtranghocphi_id' => 'id']],
            [['hocvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['hocvien_id' => 'id']],
            [['lophoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LopHoc::class, 'targetAttribute' => ['lophoc_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hocvien_id' => 'Học viên',
            'lophoc_id' => 'Lớp học',
            'status' => 'Status',
            'tinhtranghocphi_id' => 'Tình trạng đóng học phí',
            'tinhtranghoanthanh_id' => 'Tình trạng hoàn thành lớp học',
        ];
    }

    /**
     * Gets query for [[Hocvien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocvien()
    {
        return $this->hasOne(HocVien::class, ['id' => 'hocvien_id']);
    }

    /**
     * Gets query for [[Lophoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLophoc()
    {
        return $this->hasOne(LopHoc::class, ['id' => 'lophoc_id']);
    }

    /**
     * Gets query for [[Tinhtranghoanthanh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTinhtranghoanthanh()
    {
        return $this->hasOne(DmTinhtranghoanthanh::class, ['id' => 'tinhtranghoanthanh_id']);
    }

    /**
     * Gets query for [[Tinhtranghocphi]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTinhtranghocphi()
    {
        return $this->hasOne(DmTinhtranghocphi::class, ['id' => 'tinhtranghocphi_id']);
    }

}
