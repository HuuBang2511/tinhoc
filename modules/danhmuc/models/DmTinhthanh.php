<?php

namespace app\modules\danhmuc\models;

use Yii;

/**
 * This is the model class for table "dm_tinhthanh".
 *
 * @property int $id
 * @property string|null $ten
 * @property string|null $geom
 *
 * @property DmQuanhuyen[] $dmQuanhuyens
 */
class DmTinhthanh extends \yii\db\ActiveRecord

{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_tinhthanh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'geom'], 'string'],
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
            'geom' => 'Geom',
        ];
    }

    /**
     * Gets query for [[DmQuanhuyens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDmQuanhuyens()
    {
        return $this->hasMany(DmQuanhuyen::class, ['tinhthanh_id' => 'id']);
    }
}
