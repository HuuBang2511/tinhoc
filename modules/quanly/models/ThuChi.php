<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use Yii;

/**
 * This is the model class for table "thu_chi".
 *
 * @property int $id
 * @property float|null $sotien
 * @property int|null $tinhtrangtien
 * @property string|null $thongtin
 * @property int|null $status
 * @property string|null $ngay
 */
class ThuChi extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thu_chi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sotien', 'tinhtrangtien', 'thongtin', 'status', 'ngay'], 'default', 'value' => null],
            [['sotien'], 'number'],
            [['tinhtrangtien', 'status'], 'default', 'value' => null],
            [['tinhtrangtien', 'status'], 'integer'],
            [['thongtin'], 'string'],
            [['ngay'], 'safe'],
            [['tinhtrangtien', 'ngay', 'ngay'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sotien' => 'Số tiền',
            'tinhtrangtien' => 'Tình trạng tiền',
            'thongtin' => 'Thông tin chi tiêu',
            'status' => 'Status',
            'ngay' => 'Ngày',
        ];
    }

}
