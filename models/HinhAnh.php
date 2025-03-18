<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hinh_anh".
 *
 * @property int $id
 * @property string|null $duong_dan Đường dẫn
 * @property bool|null $xuat_ban Xuất bản
 * @property int|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property string|null $nguon_anh
 */
class HinhAnh extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hinh_anh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['xuat_ban'], 'boolean'],
            [['status', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['status', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['duong_dan', 'nguon_anh'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'duong_dan' => 'Đường dẫn',
            'xuat_ban' => 'Xuất bản',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'nguon_anh' => 'Nguon Anh',
        ];
    }
}
