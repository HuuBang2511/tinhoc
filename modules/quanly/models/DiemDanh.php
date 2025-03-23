<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\HocVien;
use app\modules\quanly\models\LopHoc;
use Yii;

/**
 * This is the model class for table "diem_danh".
 *
 * @property int $id
 * @property int|null $hocvien_id
 * @property int|null $lophoc_id
 * @property string|null $date
 * @property int|null $status
 * @property string|null $lydonghi
 *
 * @property HocVien $hocvien
 * @property LopHoc $lophoc
 */
class DiemDanh extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'diem_danh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hocvien_id', 'lophoc_id', 'date', 'status', 'lydonghi'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['lydonghi'], 'string'],
            [['hocvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['hocvien_id' => 'id']],
            [['lophoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LopHoc::class, 'targetAttribute' => ['lophoc_id' => 'id']],
            [['hocvien_id', 'lophoc_id', 'date'], 'required'],
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
            'date' => 'Ngày nghỉ',
            'status' => 'Status',
            'lydonghi' => 'Thông tin ',
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

}
