<?php

namespace app\modules\quanly\controllers;

use app\modules\base\BaseController;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use Yii;
use app\modules\quanly\models\Khoahoc;
use app\modules\quanly\models\LopHoc;
use app\modules\quanly\models\PhongHoc;
use app\modules\quanly\models\GiaoVien;
use app\modules\quanly\models\HocVien;
use app\modules\quanly\models\LichHoc;


class DefaultController extends BaseController
{
    public function actionIndex(){

        $count['khoahoc'] = Khoahoc::find()->where(['status' => 1])->count();
        $count['lophoc'] = LopHoc::find()->where(['status' => 1])->count();
        $count['phonghoc'] = PhongHoc::find()->where(['status' => 1])->count();
        $count['giaovien'] = GiaoVien::find()->where(['status' => 1])->count();
        $count['hocvien'] = HocVien::find()->where(['status' => 1])->count();

        $statistic['khoahoc_trinhdo'] = KhoaHoc::find()->select('count(trinhdo_id) as value, dm_trinhdo.ten as name')
        ->innerJoin('dm_trinhdo','dm_trinhdo.id = khoa_hoc.trinhdo_id')
        ->where(['khoa_hoc.status' => 1])
        ->groupBy('trinhdo_id,dm_trinhdo.ten')->asArray()->all();

        // $statistic['khoahoc_trinhdo'] = KhoaHoc::find()->select('count(trinhdo_id) as value, dm_trinhdo.ten as name')
        // ->innerJoin('dm_trinhdo','dm_trinhdo.id = khoa_hoc.trinhdo_id')
        // ->where(['khoa_hoc.status' => 1])->asArray()->all();

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
            'count' => $count,
            // 'dientichNhiembenh' => $dientichNhiembenh,
            // 'dientichVungtrong' => $dientichVungtrong,
            // 'tileNhiembenh' => $tileNhiembenh,
        ]);
    }
}