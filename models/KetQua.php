<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ket_qua".
 *
 * @property int $id
 * @property int|null $hocvien_id
 * @property int|null $lophoc_id
 * @property float|null $diemgiuaky
 * @property float|null $diemcuoiky
 * @property int|null $status
 * @property int|null $tinhtranghoanthanh_id
 *
 * @property HocVien $hocvien
 * @property LopHoc $lophoc
 * @property DmTinhtranghoanthanh $tinhtranghoanthanh
 */
class KetQua extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ket_qua';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hocvien_id', 'lophoc_id', 'diemgiuaky', 'diemcuoiky', 'status', 'tinhtranghoanthanh_id'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status', 'tinhtranghoanthanh_id'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status', 'tinhtranghoanthanh_id'], 'integer'],
            [['diemgiuaky', 'diemcuoiky'], 'number'],
            [['tinhtranghoanthanh_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTinhtranghoanthanh::class, 'targetAttribute' => ['tinhtranghoanthanh_id' => 'id']],
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
            'hocvien_id' => 'Hocvien ID',
            'lophoc_id' => 'Lophoc ID',
            'diemgiuaky' => 'Diemgiuaky',
            'diemcuoiky' => 'Diemcuoiky',
            'status' => 'Status',
            'tinhtranghoanthanh_id' => 'Tinhtranghoanthanh ID',
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

}
