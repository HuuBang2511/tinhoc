<?php

namespace app\modules\quanly\models;
use app\modules\base\BaseModel;
use app\modules\quanly\models\LopHoc;
use Yii;

/**
 * This is the model class for table "ky_thi".
 *
 * @property int $id
 * @property int|null $lophoc_id
 * @property string|null $ngay_thi
 * @property int|null $status
 * @property string|null $sochungnhan
 * @property string|null $sophoibang
 *
 * @property LopHoc $lophoc
 */
class KyThi extends BaseModel
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ky_thi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lophoc_id', 'ngay_thi', 'status', 'sochungnhan', 'sophoibang'], 'default', 'value' => null],
            [['lophoc_id', 'status'], 'default', 'value' => null],
            [['lophoc_id', 'status'], 'integer'],
            [['ngay_thi'], 'safe'],
            [['sochungnhan', 'sophoibang'], 'string'],
            [['lophoc_id'], 'exist', 'skipOnError' => true, 'targetClass' => LopHoc::class, 'targetAttribute' => ['lophoc_id' => 'id']],
            [['lophoc_id', 'ngay_thi'], 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lophoc_id' => 'Lớp học',
            'ngay_thi' => 'Ngày thi',
            'status' => 'Status',
            'sochungnhan' => 'Số chứng nhận',
            'sophoibang' => 'Số phôi bằng',
        ];
    }

    /**
     * Gets query for [[Lophoc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLophoc()
    {
        return $this->hasOne(LopHoc::class, ['id' => 'lophoc_id']);
    }

}
