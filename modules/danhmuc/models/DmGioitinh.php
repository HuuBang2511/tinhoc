<?php

namespace app\modules\danhmuc\models;

use Yii;

/**
 * This is the model class for table "dm_gioitinh".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $status
 *
 * @property GiaoVien[] $giaoViens
 * @property HocVien[] $hocViens
 */
class DmGioitinh extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_gioitinh';
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
     * Gets query for [[GiaoViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGiaoViens()
    {
        return $this->hasMany(GiaoVien::class, ['gioitinh_id' => 'id']);
    }

    /**
     * Gets query for [[HocViens]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHocViens()
    {
        return $this->hasMany(HocVien::class, ['gioitinh_id' => 'id']);
    }

}
