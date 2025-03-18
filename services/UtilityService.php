<?php


namespace app\services;


use app\modules\caytrong\models\Nongho;
use app\modules\caytrong\models\PgRanhthua;
use app\modules\danhmuc\models\DmCaytrong;
use app\modules\danhmuc\models\DmGap;
use app\modules\danhmuc\models\DmLoaiGh;
use app\modules\danhmuc\models\DmNhomGh;
use app\modules\danhmuc\models\HcPhuong;
use app\modules\danhmuc\models\HcQuan;

class UtilityService
{
    public static function convertDate($date){
        if($date != null){
            return date('d/m/Y',strtotime($date));
        } else {
            return '';
        }
    }

    public static function getRelatedInfo($model = null){
        if($model != null){
            return $model->ten;
        } else {
            return '';
        }
    }

    public static function alert($content){
        \Yii::$app->session->addFlash($content,true);
        return true;
    }

    public static  function paramValidate($id){
        if (!isset($id) || $id == null ||is_numeric($id) == false) {
            return false;
        } else {
            return true;
        }

    }

    public static function utf8convert($str) {

        if(!$str) return false;
        $utf8 = array(
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|a',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ|A',
            'd'=>'đ|d',
            'D'=>'Đ|Đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|e',
            'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ|E',
            'i'=>'í|ì|ỉ|ĩ|ị|i',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị|I',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|o',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ|O',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|u',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự|U',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ|y',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ|Y',
        );
        foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
        return $str;
    }

    public static function getCategories(){
        $categories = [];

        $categories['hcquan'] = HcQuan::find()->all();
        $categories['hcphuong'] = HcPhuong::find()->all();
        $categories['loaigayhai'] = DmLoaiGh::find()->where(['status'=>'1'])->all();
        $categories['nhomgayhai'] = DmNhomGh::find()->where(['status'=>'1'])->all();
        $categories['caytrong'] = DmCaytrong::find()->where(['status'=>'1'])->all();
        $categories['gap'] = DmGap::find()->all();

        $categories['nongho'] = Nongho::find()->where(['status'=>'1'])->all();
        $categories['ranhthua'] = PgRanhthua::find()->where(['status'=>'1'])->andWhere(['not',['mathua' => null]])->all();

        return $categories;
    }
}