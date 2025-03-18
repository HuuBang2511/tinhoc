<?php

namespace app\modules\map\models;

use Yii;

/**
 * This is the model class for table "tdp_kpq11".
 *
 * @property int $gid
 * @property string|null $tenphuong
 * @property string|null $tenquan
 * @property string|null $tento
 * @property string|null $khupho
 * @property string|null $maquan
 * @property string|null $maphuong
 * @property string|null $ghichu
 * @property float|null $shape_leng
 * @property float|null $shape_area
 * @property string|null $geom
 */
class TdpKpq11 extends \app\modules\base\BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tdp_kpq11';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['shape_leng', 'shape_area'], 'number'],
            [['geom'], 'string'],
            [['tenphuong', 'tenquan', 'tento', 'khupho', 'maphuong'], 'string', 'max' => 50],
            [['maquan'], 'string', 'max' => 53],
            [['ghichu'], 'string', 'max' => 254],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'gid' => 'Gid',
            'tenphuong' => 'Tenphuong',
            'tenquan' => 'Tenquan',
            'tento' => 'Tento',
            'khupho' => 'Khupho',
            'maquan' => 'Maquan',
            'maphuong' => 'Maphuong',
            'ghichu' => 'Ghichu',
            'shape_leng' => 'Shape Leng',
            'shape_area' => 'Shape Area',
            'geom' => 'Geom',
        ];
    }
}
