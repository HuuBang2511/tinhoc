<?php

namespace app\modules\quanly\models;

use Yii;

/**
 * This is the model class for table "v_lophoc_khoahoc".
 *
 * @property int|null $id
 * @property string|null $text
 */
class VLophocKhoahoc extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'v_lophoc_khoahoc';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'text'], 'default', 'value' => null],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
        ];
    }

}
