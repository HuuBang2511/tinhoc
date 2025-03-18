<?php

namespace app\modules\danhmuc\models;
use app\modules\base\BaseModel;
use app\modules\danhmuc\models\DmQuanhuyen;

use Yii;

/**
 * This is the model class for table "dm_phuongxa".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $quanhuyen_id
 * @property string|null $geom
 * @property string|null $geom_text
 * @property int|null $status
 * @property string|null $ten_quan
 *
 * @property DmQuanhuyen $quanhuyen
 */
class DmPhuongxa extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_phuongxa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'geom', 'geom_text', 'ten_quan'], 'string'],
            [['quanhuyen_id', 'status'], 'default', 'value' => null],
            [['quanhuyen_id', 'status'], 'integer'],
            [['quanhuyen_id'], 'exist', 'skipOnError' => true, 'targetClass' => DmQuanhuyen::class, 'targetAttribute' => ['quanhuyen_id' => 'id']],
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
            'quanhuyen_id' => 'Quanhuyen ID',
            'geom' => 'Geom',
            'geom_text' => 'Geom Text',
            'status' => 'Status',
            'ten_quan' => 'Ten Quan',
        ];
    }

    /**
     * Gets query for [[Quanhuyen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuanhuyen()
    {
        return $this->hasOne(DmQuanhuyen::class, ['id' => 'quanhuyen_id']);
    }
}
