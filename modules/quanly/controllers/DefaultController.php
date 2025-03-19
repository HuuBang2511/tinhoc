<?php

namespace app\modules\quanly\controllers;

use app\modules\base\BaseController;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use Yii;


class DefaultController extends BaseController
{
    public function actionIndex(){

        // $count['nongho'] = NongHo::find()->where(['status' => 1])->count();
        // $count['diagioi_hanhchinh'] = DiagioiHanhchinh::find()->where(['status' => 1])->count();
        // $count['caytrong_canhtac'] = CaytrongCanhtac::find()->where(['status' => 1])->count();
        // $count['cuahang_thuocbaove'] = CuahangThuocbaove::find()->where(['status' => 1])->count();

        // $vungTrong = CaytrongCanhtac::find()->select('sum(dien_tich)')->where(['status' => 1])->andWhere('dien_tich is not null')->asArray()->all();
        // $nhiemBenh = DienbienDichbenh::find()->select('sum(dientich_nhiembenh)')->where(['status' => 1])->andWhere('dientich_nhiembenh is not null')->asArray()->all();

        // $dientichNhiembenh = $nhiemBenh[0]['sum'];
        // $dientichVungtrong = $vungTrong[0]['sum'];

        
        // if($dientichNhiembenh != null && $dientichVungtrong != null && $dientichVungtrong != 0 && $dientichNhiembenh != 0){
        //     $tileNhiembenh = (int)(($dientichNhiembenh/$dientichVungtrong) * 100);
        // }else{
        //     $tileNhiembenh = 0;
        // }

        //dd($count);

        return $this->render('index', [
            // 'count' => $count,
            // 'dientichNhiembenh' => $dientichNhiembenh,
            // 'dientichVungtrong' => $dientichVungtrong,
            // 'tileNhiembenh' => $tileNhiembenh,
        ]);
    }
}