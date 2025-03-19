<?php

namespace app\modules\danhmuc\models;

use Yii;

/**
 * This is the model class for table "dm_tinhtranglophoc".
 *
 * @property int $id
 * @property string|null $ten
 * @property int|null $status
 *
 * @property LopHoc[] $lopHocs
 */
class DmTinhtranglophoc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dm_tinhtranglophoc';
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
     * Gets query for [[LopHocs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLopHocs()
    {
        return $this->hasMany(LopHoc::class, ['tinhtranglophoc_id' => 'id']);
    }

}
