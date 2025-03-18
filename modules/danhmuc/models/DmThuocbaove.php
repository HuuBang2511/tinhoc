<?php

namespace app\modules\danhmuc\models;
use app\modules\base\BaseModel;

use Yii;

/**
 * This is the model class for table "dm_thuocbaove".
 *
 * @property int $id
 * @property string|null $ten
 * @property string|null $ghi_chu
 * @property int|null $status
 * @property string|null $dac_tri
 * @property string|null $thanh_phan
 * @property string|null $dang_thuoc
 * @property string|null $quytac_donggoi
 * @property string|null $url_hinhanh
 *
 * @property CuahangThuocbaove[] $cuahangThuocbaoves
 * @property ThongTinBenh[] $thongTinBenhs
 */
class DmThuocbaove extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_thuocbaove';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'ghi_chu', 'dac_tri', 'thanh_phan', 'dang_thuoc', 'quytac_donggoi', 'url_hinhanh'], 'string'],
            [['status'], 'default', 'value' => null],
            [['status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên thuốc bảo vệ',
            'ghi_chu' => 'Ghi chú',
            'status' => 'Status',
            'dac_tri' => 'Đặc trị',
            'thanh_phan' => 'Thành phần',
            'dang_thuoc' => 'Dạng thuốc',
            'quytac_donggoi' => 'Quy tắc đóng gói',
            'url_hinhanh' => 'Url Hinhanh',
        ];
    }

    /**
     * Gets query for [[CuahangThuocbaoves]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuahangThuocbaoves()
    {
        return $this->hasMany(CuahangThuocbaove::class, ['thuocbaove_id' => 'id']);
    }

    /**
     * Gets query for [[ThongTinBenhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThongTinBenhs()
    {
        return $this->hasMany(ThongTinBenh::class, ['thuocbaove_id' => 'id']);
    }
}
