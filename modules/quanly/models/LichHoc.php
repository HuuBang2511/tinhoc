<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\PhongHoc;
use app\modules\quanly\models\LopHoc;
use app\modules\quanly\models\GiaoVien;
use Yii;

/**
 * This is the model class for table "lich_hoc".
 *
 * @property int $id
 * @property int|null $lophoc_id
 * @property int|null $giaovien_id
 * @property float|null $giobatdau
 * @property float|null $gioketthuc
 * @property int|null $thutrongtuan
 * @property int|null $status
 * @property int|null $phonghoc_id
 *
 * @property GiaoVien $giaovien
 * @property LopHoc $lophoc
 * @property PhongHoc $phonghoc
 */
class LichHoc extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lich_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lophoc_id', 'giaovien_id', 'giobatdau', 'gioketthuc', 'thutrongtuan', 'status', 'phonghoc_id'], 'default', 'value' => null],
            [['lophoc_id', 'giaovien_id', 'thutrongtuan', 'status', 'phonghoc_id'], 'default', 'value' => null],
            [['lophoc_id', 'giaovien_id', 'thutrongtuan', 'status', 'phonghoc_id'], 'integer'],
            [['giobatdau', 'gioketthuc'], 'number'],
            [['giaovien_id'], 'exist', 'skipOnError' => true, 'targetClass' => GiaoVien::class, 'targetAttribute' => ['giaovien_id' => 'id']],
            [['lophoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LopHoc::class, 'targetAttribute' => ['lophoc_id' => 'id']],
            [['phonghoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhongHoc::class, 'targetAttribute' => ['phonghoc_id' => 'id']],
            [['thutrongtuan', 'giobatdau', 'gioketthuc'], 'required'],
            //[['gioketthuc'], 'number', 'min' >= 'giobatdau'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lophoc_id' => 'Lớp học',
            'giaovien_id' => 'Giáo viên',
            'giobatdau' => 'Giờ bắt đầu',
            'gioketthuc' => 'Giờ kết thúc',
            'thutrongtuan' => 'Thứ trong tuần',
            'status' => 'Status',
            'phonghoc_id' => 'Phòng học',
        ];
    }

    /**
     * Gets query for [[Giaovien]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaovien()
    {
        return $this->hasOne(GiaoVien::class, ['id' => 'giaovien_id']);
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
     * Gets query for [[Phonghoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhonghoc()
    {
        return $this->hasOne(PhongHoc::class, ['id' => 'phonghoc_id']);
    }

}
