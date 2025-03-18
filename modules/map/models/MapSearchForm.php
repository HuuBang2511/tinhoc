<?php

namespace app\modules\map\models;

use yii\base\Model;

class MapSearchForm extends Model
{
    public $ten;
    public $sonha;
    public $tenduong;
    public $todanpho;
    public $khupho;
    public $phuongxa;
    public $loaidonvikinhte;
    public $linhvuc;
    public $tinhtrangtheophuong;

    public function rules()
    {
        return [
            [['ten','sonha','tenduong','todanpho','khupho'],'string'],
            [['phuongxa', 'loaidonvikinhte', 'linhvuc', 'tinhtrangtheophuong'],'integer'],
        ];
    }
}