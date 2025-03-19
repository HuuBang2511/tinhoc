<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\danhmuc\models\DmTrinhdo;

use Yii;

/**
 * This is the model class for table "khoa_hoc".
 *
 * @property int $id
 * @property string|null $ma
 * @property string|null $ten
 * @property float|null $hocphi
 * @property string|null $thoigian_khoahoc
 * @property int|null $trinhdo_id
 * @property int|null $status
 *
 * @property DmTrinhdo $dmTrinhdo
 */
class KhoaHoc extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'khoa_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ma', 'ten', 'hocphi', 'thoigian_khoahoc', 'trinhdo_id', 'status'], 'default', 'value' => null],
            [['ma', 'ten', 'thoigian_khoahoc'], 'string'],
            [['hocphi'], 'number'],
            [['trinhdo_id', 'status'], 'default', 'value' => null],
            [['trinhdo_id', 'status'], 'integer'],
            [['trinhdo_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTrinhdo::class, 'targetAttribute' => ['trinhdo_id' => 'id']],
            [['hocphi'], 'match', 'pattern' => '/^([0-9.,])+$/'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ma' => 'Mã khóa học',
            'ten' => 'Tên khóa học',
            'hocphi' => 'Học phí khóa học',
            'thoigian_khoahoc' => 'Thời gian khóa học',
            'trinhdo_id' => 'Trình độ',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[DmTrinhdo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrinhdo()
    {
        return $this->hasOne(DmTrinhdo::class, ['id' => 'trinhdo_id']);
    }

}
