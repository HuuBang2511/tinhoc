<?php

namespace app\modules\map\controllers;

use app\modules\base\Config;
use app\modules\base\Constant;
use yii\caching\ExpressionDependency;
use yii\data\Pagination;
use yii\db\Query;
use yii\web\Controller;
use Yii;
use app\modules\quanly\models\NongHo;
use app\modules\quanly\models\DiagioiHanhchinh;
use app\modules\quanly\models\CuahangThuocbaove;
use app\modules\quanly\models\CaytrongCanhtac;
use app\modules\danhmuc\models\DmPhuongxa;
use app\modules\danhmuc\models\DmQuanhuyen;

/**
 * Default controller for the `map` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        
        return $this->render('index');
    }

    public function actionNongHo(){
        $nongho = NongHo::find()->select(['id', 'geo_x', 'geo_y', 'ma_nong_ho', 'chunongho_ten', 'dia_chi'])->where(['status' => 1])->asArray()->all();
        return json_encode($nongho);
    }

    public function actionCuahangThuocbaove(){
        $cuahang = CuahangThuocbaove::find()->select(['id', 'geo_x', 'geo_y', 'ten_cua_hang', 'dia_chi'])->where(['status' => 1])->asArray()->all();
        return json_encode($cuahang);
    }

    public function actionRanhXa(){
        $phuongxa = DmPhuongxa::find()->select(['id', 'st_asgeojson(geom) as geom_text', 'ten', 'ten_quan'])->asArray()->all();

        $object = [];

        foreach ($phuongxa as $i => $item){
            $geojson = json_decode($item['geom_text'], true);
            $object[] = [
                'properties' => [
                    'ten' => $item['ten'],
                    'ten_quan' => $item['ten_quan'],
                    
                ],
                'type' => $geojson['type'],
                'coordinates' => $geojson['coordinates'],
            ];
            //dd($geojson);
        }
        return json_encode($object);
    }

    public function actionRanhQuan(){
        $quanhuyen = DmQuanhuyen::find()->select(['id', 'st_asgeojson(geom) as geom_text', 'ten'])->asArray()->all();

        $object = [];

        foreach ($quanhuyen as $i => $item){
            $geojson = json_decode($item['geom_text'], true);
            $object[] = [
                'properties' => [
                    'ten' => $item['ten'],                    
                ],
                'type' => $geojson['type'],
                'coordinates' => $geojson['coordinates'],
            ];
            //dd($geojson);
        }
        return json_encode($object);
    }

    public function actionDiagioiHanhchinh(){
        $diagioi = DiagioiHanhchinh::find()->select(['id', 'geom_text', 'ma_diagioi_hanhchinh', 'ten'])->where(['status' => 1])->asArray()->all();

        $object = [];

        foreach ($diagioi as $i => $item){
            $geojson = json_decode($item['geom_text'], true);
            $object[] = [
                'properties' => [
                    'id' => $item['id'],
                    'ma_diagioi_hanhchinh' => $item['ma_diagioi_hanhchinh'],
                    'ten' => $item['ten'],
                    
                ],
                'type' => $geojson['type'],
                'coordinates' => $geojson['coordinates'],
            ];
            //dd($geojson);
        }
        return json_encode($object);
    }

    public function actionCaytrongCanhtac(){
        $caytrongCanhtac = CaytrongCanhtac::find()->select(['caytrong_canhtac.id' ,'caytrong_canhtac.geom_text', 'caytrong_canhtac.dien_tich', 'caytrong_canhtac.ten_vung' ,'ma_diagioi_hanhchinh', 'loai_cay_trong.ten as loaicaytrong'])
        ->innerJoin('diagioi_hanhchinh', 'diagioi_hanhchinh.id = caytrong_canhtac.diagioihanhchinh_id')
        ->innerJoin('loai_cay_trong', 'loai_cay_trong.id = caytrong_canhtac.loaicaytrong_id')
        ->where(['caytrong_canhtac.status' => 1])->asArray()->all();

        $object = [];

        foreach ($caytrongCanhtac as $i => $item){
            $geojson = json_decode($item['geom_text'], true);
            $object[] = [
                'properties' => [
                    'id' => $item['id'],
                    'dientich' => $item['dien_tich'],
                    'ma_diagioi_hanhchinh' => $item['ma_diagioi_hanhchinh'],
                    'ten_vung' => $item['ten_vung'],
                    'loaicaytrong' => $item['loaicaytrong'],
                ],
                'type' => $geojson['type'],
                'coordinates' => $geojson['coordinates'],
            ];
            //dd($geojson);
        }
        return json_encode($object);
    }

    public function actionVungtrong($id){
        $caytrongCanhtac = CaytrongCanhtac::find()->select(['caytrong_canhtac.id' ,'caytrong_canhtac.geom_text', 'caytrong_canhtac.dien_tich', 'caytrong_canhtac.ten_vung' ,'ma_diagioi_hanhchinh', 'loai_cay_trong.ten as loaicaytrong'])
        ->innerJoin('diagioi_hanhchinh', 'diagioi_hanhchinh.id = caytrong_canhtac.diagioihanhchinh_id')
        ->innerJoin('loai_cay_trong', 'loai_cay_trong.id = caytrong_canhtac.loaicaytrong_id')
        ->where(['caytrong_canhtac.status' => 1])->andWhere(['caytrong_canhtac.loaicaytrong_id' => $id])->asArray()->all();

        $object = [];

        foreach ($caytrongCanhtac as $i => $item){
            $geojson = json_decode($item['geom_text'], true);
            $object[] = [
                'properties' => [
                    'id' => $item['id'],
                    'dientich' => $item['dien_tich'],
                    'ma_diagioi_hanhchinh' => $item['ma_diagioi_hanhchinh'],
                    'ten_vung' => $item['ten_vung'],
                    'loaicaytrong' => $item['loaicaytrong'],
                ],
                'type' => $geojson['type'],
                'coordinates' => $geojson['coordinates'],
            ];
            //dd($geojson);
        }
        return json_encode($object);
    }

    
}
