<?php

namespace app\modules\danhmuc\models;

use Yii;

/**
 * This is the model class for table "dm_trinhdo".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $status
 *
 * @property KhoaHoc[] $khoaHocs
 */
class DmTrinhdo extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_trinhdo';
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
     * Gets query for [[KhoaHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getKhoaHocs()
    {
        return $this->hasMany(KhoaHoc::class, ['trinhdo_id' => 'id']);
    }

}
