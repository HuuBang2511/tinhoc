<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use Yii;

/**
 * This is the model class for table "phong_hoc".
 *
 * @property int $id
 * @property string|null $ten
 * @property string|null $ma
 * @property int|null $status
 * @property string|null $ghichu
 *
 * @property LichHoc[] $lichHocs
 */
class PhongHoc extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phong_hoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'ma', 'status', 'ghichu'], 'default', 'value' => null],
            [['ten', 'ma', 'ghichu'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
            [['ma', 'ten'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên phòng học',
            'ma' => 'Mã',
            'status' => 'Status',
            'ghichu' => 'Ghi chú',
        ];
    }

    /**
     * Gets query for [[LichHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLichHocs()
    {
        return $this->hasMany(LichHoc::class, ['phonghoc_id' => 'id']);
    }

}
