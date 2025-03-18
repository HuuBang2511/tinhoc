<?php

namespace app\modules\danhmuc\models;
use app\modules\danhmuc\DmTinhtranh;
use app\modules\base\BaseModel;

use Yii;

/**
 * This is the model class for table "dm_quanhuyen".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $status
 * @property string|null $geom
 * @property int|null $tinhthanh_id
 *
 * @property DmPhuongxa[] $dmPhuongxas
 * @property DmTinhthanh $tinhthanh
 */
class DmQuanhuyen extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_quanhuyen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'geom'], 'string'],
            [['status', 'tinhthanh_id'], 'default', 'value' => null],
            [['status', 'tinhthanh_id'], 'integer'],
            [['tinhthanh_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmTinhthanh::class, 'targetAttribute' => ['tinhthanh_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten' => 'Ten',
            'status' => 'Status',
            'geom' => 'Geom',
            'tinhthanh_id' => 'Tinhthanh ID',
        ];
    }

    /**
     * Gets query for [[DmPhuongxas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDmPhuongxas()
    {
        return $this->hasMany(DmPhuongxa::class, ['quanhuyen_id' => 'id']);
    }

    /**
     * Gets query for [[Tinhthanh]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTinhthanh()
    {
        return $this->hasOne(DmTinhthanh::class, ['id' => 'tinhthanh_id']);
    }
}
