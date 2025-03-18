<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\LoaiCayTrong;
use app\modules\quanly\models\NongHo;
use app\modules\quanly\models\ThongTinBenh;

use Yii;

/**
 * This is the model class for table "dienbien_dichbenh".
 *
 * @property int $id
 * @property int|null $loaicaytrong_id
 * @property int|null $thongtinbenh_id
 * @property int|null $nongho_id
 * @property float|null $dientich_nhiembenh
 * @property string|null $thoi_diem
 * @property int|null $status
 * @property int|null $caytrongcanhtac_id
 *
 * @property CaytrongCanhtac $caytrongcanhtac
 * @property LoaiCayTrong $loaicaytrong
 * @property NongHo $nongho
 * @property ThongTinBenh $thongtinbenh
 */
class DienbienDichbenh extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dienbien_dichbenh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loaicaytrong_id', 'thongtinbenh_id', 'nongho_id', 'status', 'caytrongcanhtac_id'], 'default', 'value' => null],
            [['loaicaytrong_id', 'thongtinbenh_id', 'nongho_id', 'status', 'caytrongcanhtac_id'], 'integer'],
            //[['dientich_nhiembenh'], 'number'],
            [['dientich_nhiembenh'], 'match', 'pattern' => '/^([0-9.,])+$/'],
            [['thoi_diem'], 'string'],
            [['caytrongcanhtac_id'], 'exist', 'skipOnError' => true, 'targetClass' => CaytrongCanhtac::class, 'targetAttribute' => ['caytrongcanhtac_id' => 'id']],
            [['loaicaytrong_id'], 'exist', 'skipOnError' => true, 'targetClass' => LoaiCayTrong::class, 'targetAttribute' => ['loaicaytrong_id' => 'id']],
            [['nongho_id'], 'exist', 'skipOnError' => true, 'targetClass' => NongHo::class, 'targetAttribute' => ['nongho_id' => 'id']],
            [['thongtinbenh_id'], 'exist', 'skipOnError' => true, 'targetClass' => ThongTinBenh::class, 'targetAttribute' => ['thongtinbenh_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'loaicaytrong_id' => 'Loại cây trồng',
            'thongtinbenh_id' => 'Thông tin bệnh',
            'nongho_id' => 'Nông hộ',
            'dientich_nhiembenh' => 'Diện tích nhiễm bệnh',
            'thoi_diem' => 'Thời điểm',
            'status' => 'Status',
            'caytrongcanhtac_id' => 'Thông tin vùng cây trồng canh tác',
        ];
    }

    /**
     * Gets query for [[Caytrongcanhtac]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCaytrongcanhtac()
    {
        return $this->hasOne(CaytrongCanhtac::class, ['id' => 'caytrongcanhtac_id']);
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
     * Gets query for [[Nongho]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNongho()
    {
        return $this->hasOne(NongHo::class, ['id' => 'nongho_id']);
    }

    /**
     * Gets query for [[Thongtinbenh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getThongtinbenh()
    {
        return $this->hasOne(ThongTinBenh::class, ['id' => 'thongtinbenh_id']);
    }
}
