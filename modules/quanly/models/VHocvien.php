<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;

use Yii;

/**
 * This is the model class for table "v_hocvien".
 *
 * @property int|null $id
 * @property string|null $text
 */
class VHocvien extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'v_hocvien';
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
