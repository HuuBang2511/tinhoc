<?php

namespace app\modules\danhmuc\models;

use Yii;

/**
 * This is the model class for table "dm_tinhtranghoanthanh".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $status
 *
 * @property HocvienLophoc[] $hocvienLophocs
 * @property KetQua[] $ketQuas
 */
class DmTinhtranghoanthanh extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_tinhtranghoanthanh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ten', 'status'], 'default', 'value' => null],
            [['ten'], 'string'],
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
            'ten' => 'Ten',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[HocvienLophocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocvienLophocs()
    {
        return $this->hasMany(HocvienLophoc::class, ['tinhtranghoanthanh_id' => 'id']);
    }

    /**
     * Gets query for [[KetQuas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKetQuas()
    {
        return $this->hasMany(KetQua::class, ['tinhtranghoanthanh_id' => 'id']);
    }

}
