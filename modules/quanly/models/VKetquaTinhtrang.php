<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;

use Yii;

/**
 * This is the model class for table "v_ketqua_tinhtrang".
 *
 * @property int|null $lophoc_id
 * @property int|null $hocvien_id
 * @property float|null $diemgiuaky
 * @property float|null $diemcuoiky
 * @property string|null $ten
 */
class VKetquaTinhtrang extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'v_ketqua_tinhtrang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lophoc_id', 'hocvien_id', 'diemgiuaky', 'diemcuoiky', 'ten'], 'default', 'value' => null],
            [['lophoc_id', 'hocvien_id'], 'default', 'value' => null],
            [['lophoc_id', 'hocvien_id'], 'integer'],
            [['diemgiuaky', 'diemcuoiky'], 'number'],
            [['ten'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'lophoc_id' => 'Lophoc ID',
            'hocvien_id' => 'Hocvien ID',
            'diemgiuaky' => 'Diemgiuaky',
            'diemcuoiky' => 'Diemcuoiky',
            'ten' => 'Ten',
        ];
    }

    public function getHocvien()
    {
        return $this->hasOne(HocPhi::class, ['id' => 'hocvien_id']);
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
