<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\LoaiCayTrong;
use app\modules\quanly\models\DiagioiHanhchinh;

use Yii;

/**
 * This is the model class for table "caytrong_canhtac".
 *
 * @property int $id
 * @property int|null $loaicaytrong_id
 * @property float|null $dien_tich
 * @property int|null $status
 * @property string|null $geom
 * @property string|null $geom_text
 * @property int|null $diagioihanhchinh_id
 * @property string|null $ten_vung
 *
 * @property DiagioiHanhchinh $diagioihanhchinh
 * @property DienbienDichbenh[] $dienbienDichbenhs
 * @property LoaiCayTrong $loaicaytrong
 */
class CaytrongCanhtac extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'caytrong_canhtac';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['loaicaytrong_id', 'status', 'diagioihanhchinh_id'], 'default', 'value' => null],
            [['loaicaytrong_id', 'status', 'diagioihanhchinh_id'], 'integer'],
            //[['dien_tich'], 'number'],
            [['dien_tich'], 'match', 'pattern' => '/^([0-9.,])+$/'],
            [['geom', 'geom_text', 'ten_vung'], 'string'],
            [['diagioihanhchinh_id'], 'exist', 'skipOnError' => true, 'targetClass' => DiagioiHanhchinh::class, 'targetAttribute' => ['diagioihanhchinh_id' => 'id']],
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
            'loaicaytrong_id' => 'Loại cây trồng',
            'dien_tich' => 'Diện tích',
            'status' => 'Status',
            'geom' => 'Geom',
            'geom_text' => 'Geom Text',
            'diagioihanhchinh_id' => 'Địa giới hành chính',
            'ten_vung' => 'Tên vùng',
        ];
    }

    /**
     * Gets query for [[Diagioihanhchinh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDiagioihanhchinh()
    {
        return $this->hasOne(DiagioiHanhchinh::class, ['id' => 'diagioihanhchinh_id']);
    }

    /**
     * Gets query for [[DienbienDichbenhs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDienbienDichbenhs()
    {
        return $this->hasMany(DienbienDichbenh::class, ['caytrongcanhtac_id' => 'id']);
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
}
