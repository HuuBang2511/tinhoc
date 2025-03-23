<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\Hocvien;
use app\modules\quanly\models\LopHoc;

use Yii;

/**
 * This is the model class for table "hoc_phi".
 *
 * @property int $id
 * @property int|null $hocvien_id
 * @property int|null $lophoc_id
 * @property float|null $sotien
 * @property int|null $status
 *
 * @property HocVien $hocvien
 * @property LopHoc $lophoc
 */
class HocPhi extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hoc_phi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hocvien_id', 'lophoc_id', 'sotien', 'status'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status'], 'default', 'value' => null],
            [['hocvien_id', 'lophoc_id', 'status'], 'integer'],
            //[['sotien'], 'number'],
            [['hocvien_id'], 'exist', 'skipOnError' => true, 'targetClass' => HocVien::class, 'targetAttribute' => ['hocvien_id' => 'id']],
            [['lophoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LopHoc::class, 'targetAttribute' => ['lophoc_id' => 'id']],
            [['sotien'], 'match', 'pattern' => '/^([0-9.,])+$/'],
            [['hocvien_id', 'lophoc_id', 'sotien'], 'required'],
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
            'sotien' => 'Số tiền',
            'status' => 'Status',
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
