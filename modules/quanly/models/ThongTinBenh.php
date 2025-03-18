<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\LoaiCayTrong;
use app\modules\danhmuc\models\DmThuocbaove;

use Yii;

/**
 * This is the model class for table "thong_tin_benh".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $loaicaytrong_id
 * @property string|null $thongtin_benh
 * @property int|null $status
 * @property int|null $thuocbaove_id
 * @property string|null $thuoc_bao_ve
 *
 * @property DienbienDichbenh[] $dienbienDichbenhs
 * @property LoaiCayTrong $loaicaytrong
 * @property DmThuocbaove $thuocbaove
 */
class ThongTinBenh extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'thong_tin_benh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'thongtin_benh'], 'string'],
            [['thuoc_bao_ve'], 'safe'],
            [['loaicaytrong_id', 'status', 'thuocbaove_id'], 'default', 'value' => null],
            [['loaicaytrong_id', 'status', 'thuocbaove_id'], 'integer'],
            [['thuocbaove_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmThuocbaove::class, 'targetAttribute' => ['thuocbaove_id' => 'id']],
            [['loaicaytrong_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiCayTrong::class, 'targetAttribute' => ['loaicaytrong_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Tên bệnh',
            'loaicaytrong_id' => 'Loại cây trồng',
            'thongtin_benh' => 'Thông tin bệnh',
            'status' => 'Status',
            'thuocbaove_id' => 'Thuốc bảo vệ',
            'thuoc_bao_ve' => 'Thuốc bảo vệ',
        ];
    }

    /**
     * Gets query for [[DienbienDichbenhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDienbienDichbenhs()
    {
        return $this->hasMany(DienbienDichbenh::class, ['thongtinbenh_id' => 'id']);
    }

    /**
     * Gets query for [[Loaicaytrong]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLoaicaytrong()
    {
        return $this->hasOne(LoaiCayTrong::class, ['id' => 'loaicaytrong_id']);
    }

    /**
     * Gets query for [[Thuocbaove]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThuocbaove()
    {
        return $this->hasOne(DmThuocbaove::class, ['id' => 'thuocbaove_id']);
    }
}
