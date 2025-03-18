<?php

namespace app\modules\quanly\models;

use app\modules\danhmuc\models\DmThuocbaove;
use app\modules\quanly\models\NongHo;
use app\modules\quanly\models\CuahangThuocbaove;
use app\modules\quanly\models\ThongTinBenh;

use Yii;
use yii\base\Model;
use yii\db\Query;

class FormTimduong extends Model{
    public $nongho_id, $loaibenh_id;

    public function rules()
    {
        return [
            [['loaibenh_id', 'nongho_id'],'safe'],
            [['loaibenh_id', 'nongho_id'],'required','message' => 'Dữ liệu bắt buộc!']
        ];
    }

    public function attributeLabels()
    {
        return [
            'loaibenh_id' => 'Loại bệnh',
            'nongho_id' => 'Nông hộ',
        ];
    }

    // public function FindMap(){
    //     $nongho = NongHo::findOne($this->nongho_id);
    //     $cuahang = CuaHangThuocbaove::find()->where(['status' => 1])->all();

    //     $cuahangThuoc = [];

    //     foreach ($cuahang as $i => $item){
    //         if($item->thuoc_bao_ve != null){
    //             $thuocbaove = json_decode($item->thuoc_bao_ve);
    //             if(in_array($this->loaibenh_id, $thuocbaove)){
    //                 $cuahangThuoc[] = $item;
    //             }

    //         }
    //     }

    //     if(count($cuahangThuoc) > 0){

    //         $khoangcach = [];

    //         foreach ($cuahangThuoc as $i => $item){
    //             if($item->geo_x != null && $item->geo_y != null){
    //                 $dist = (new Query())->select(['ST_Distance(st_transform(st_setsrid(st_makepoint(' . $item->geo_x . ',' . $item->geo_y . '), 4326), 32648),st_transform(st_setsrid(st_makepoint(' . $nongho->geo_x . ',' . $nongho->geo_y . '), 4326), 32648)) as dist'])->from('nong_ho')->one();

    //                 $khoangcach[] = [
    //                     'cuahang' => $item,
    //                     'dist' => $dist['dist'],
    //                 ];
    //             }
    //         }

    //         dd($khoangcach);
    //     }else{
    //         $content = [
    //             'nongho' => $nongho,
    //             'cuahang' => null,
    //         ];

    //         return $content;
    //     }

        
    // }
}