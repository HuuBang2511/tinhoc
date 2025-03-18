<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\DiagioiHanhchinh;
use app\modules\quanly\models\DiagioiHanhchinhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\quanly\models\DienbienDichbenh;
use app\modules\quanly\models\CaytrongCanhtac;

/**
 * DiagioiHanhchinhController implements the CRUD actions for DiagioiHanhchinh model.
 */
class DiagioiHanhchinhController extends BaseController
{

    //public $title = "Địa giới hành chính";

    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Địa giới hành chính',
            'label' => [
                'index' => 'Danh sách',
                'create' => 'Thêm mới',
                'update' => 'Cập nhật',
                'view' => 'Thông tin chi tiết',
                'statistic' => 'Thống kê',
            ],
            'url' => [
                'index' => 'index',
                'create' => 'Thêm mới',
                'update' => 'Cập nhật',
                'view' => 'Thông tin chi tiết',
                'statistic' => 'Thống kê',
            ],
        ];
    }

    /**
     * Lists all DiagioiHanhchinh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DiagioiHanhchinhSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['DiagioiHanhchinhSearch']['status'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single DiagioiHanhchinh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        $caytrongcanhtac = CaytrongCanhtac::find()->where(['status' => 1])->andWhere(['diagioihanhchinh_id' => $id])->all();

        $vungtrongCanhtac = CaytrongCanhtac::find()->where(['status' => 1])->andWhere(['diagioihanhchinh_id' => $id])->all();

        if($vungtrongCanhtac != null){
            $vungtrong_id = [];

            foreach ($vungtrongCanhtac as $i => $item){
                $vungtrong_id[] = $item->id;
            }

            $vungTrong = CaytrongCanhtac::find()->select('sum(dien_tich)')->where(['status' => 1])->andWhere('dien_tich is not null')->andWhere(['diagioihanhchinh_id' => $id])->asArray()->all();


            $vungNhiembenh = DienbienDichbenh::find()->select('sum(dientich_nhiembenh)')->where(['status' => 1])->andWhere('dientich_nhiembenh is not null')->andWhere(['in', 'caytrongcanhtac_id', $vungtrong_id ])->asArray()->all();

            $dientichNhiembenh = $vungNhiembenh[0]['sum'];
            $dientichVungtrong = $vungTrong[0]['sum'];

            if($dientichNhiembenh != null && $dientichVungtrong != null && $dientichVungtrong != 0 && $dientichNhiembenh != 0){
                $tileNhiembenh = (int)(($dientichNhiembenh/$dientichVungtrong) * 100);
            }else{
                $tileNhiembenh = 0;
            }
        }else{
            $dientichNhiembenh = 0;
            $dientichVungtrong = 0;
            $tileNhiembenh = 0;
        }

        if($caytrongcanhtac != null){
            $dataMapCaytrong = [];
            foreach($caytrongcanhtac as $i => $item){
                $geojson = json_decode($item->geom_text, true);
                $dataMapCaytrong[] = [
                    'properties' => [
                        'ten_vung' => $item->ten_vung,                
                    ],
                    'type' => $geojson['type'],
                    'coordinates' => $geojson['coordinates'],
                ];
            }
            $dataMapCaytrong = json_encode($dataMapCaytrong);
        }else{
            $dataMapCaytrong = null;
        }

        //dd($dataMapCaytrong);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
            'caytrongcanhtac' => $caytrongcanhtac,
            'dientichVungtrong' => $dientichVungtrong,
            'dientichNhiembenh' => $dientichNhiembenh,
            'tileNhiembenh' => $tileNhiembenh,
            'dataMapCaytrong' => $dataMapCaytrong,
        ]);
    }

    /**
     * Creates a new DiagioiHanhchinh model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DiagioiHanhchinh();

        if ($model->load(Yii::$app->request->post())) {
            $dataMap = $model->geom_text;

            $dataMap = json_decode($dataMap, true);
            $dataMap = array_values($dataMap);
            $dataMap = json_encode($dataMap, true);
            //dd(($dataMap));

            $geom_text = '{"type":"MultiPolygon","coordinates":'.$dataMap.'}';

            $model->geom_text = $geom_text;

            $model->save();

            Yii::$app->db
            ->createCommand("UPDATE diagioi_hanhchinh SET geom = ST_SETSRID(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('".$model->geom_text."'))),4326) WHERE id = :id")
            ->bindValue(':id', $model->id)
            ->execute();

            return $this->redirect(['view', 'id' => $model->id]);
        }   

        return $this->render('create',[
            'model' => $model
        ]);

    }

    /**
     * Updates an existing DiagioiHanhchinh model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $oldGeomGeojson = $model->geom_text;

        if ($model->load(Yii::$app->request->post())) {
            if($model->geom_text !== $oldGeomGeojson){
                $dataMap = $model->geom_text;

                $dataMap = json_decode($dataMap, true);
                $dataMap = array_values($dataMap);
                $dataMap = json_encode($dataMap, true);
                //dd(($dataMap));

                $geom_text = '{"type":"MultiPolygon","coordinates":'.$dataMap.'}';

                $model->geom_text = $geom_text;

                Yii::$app->db->createCommand("UPDATE diagioi_hanhchinh SET geom = ST_SETSRID(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('".$model->geom_text."'))),4326) WHERE id = :id")
                ->bindValue(':id', $id)
                ->execute();
            }

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update',[
            'model' => $model
        ]);
    }

    /**
     * Delete an existing DiagioiHanhchinh model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isPost) {
                $model->status = 0;
                $model->save();
                return [
                    'title' => "Xóa địa giới hành chính",
                    'content' => '<span class="text-success">Xóa dữ liệu dữ liệu địa giới hành chính thành công</span>',
                    'forceReload' => '#crud-datatable-pjax',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Xóa dữ liệu địa giới hành chính" . $id,
                    'content' => $this->renderAjax('delete', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"]) .
                        Html::submitButton('Xóa', ['class' => 'btn btn-danger float-start'])
                ];
            }
        } else {
            return $this->redirect(['index']);
        }
    }

    
    /**
     * Finds the DiagioiHanhchinh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DiagioiHanhchinh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DiagioiHanhchinh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
