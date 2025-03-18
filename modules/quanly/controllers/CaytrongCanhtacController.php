<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\CaytrongCanhtac;
use app\modules\quanly\models\CaytrongCanhtacSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\quanly\models\DiagioiHanhchinh;
use app\modules\quanly\models\LoaiCayTrong;
use app\modules\quanly\models\DienbienDichbenh;


/**
 * CaytrongCanhtacController implements the CRUD actions for CaytrongCanhtac model.
 */
class CaytrongCanhtacController extends BaseController
{
    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Cây trồng canh tác',
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
     * Lists all CaytrongCanhtac models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CaytrongCanhtacSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['CaytrongCanhtacSearch']['status'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        $categories['diagioi_hanhchinh'] = DiagioiHanhchinh::find()->where(['status' => 1])->all();
        $categories['loaicaytrong'] = LoaiCayTrong::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => $categories
        ]);
    }


    /**
     * Displays a single CaytrongCanhtac model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        $dienbien = DienbienDichbenh::find()->where(['caytrongcanhtac_id' => $id])->andWhere(['status' => 1])->orderBy('id DESC')->one();

        $diagioihanhchinh = DiagioiHanhchinh::findOne($model->diagioihanhchinh_id);
        
            return $this->render('view', [
                'model' => $model,
                'diagioihanhchinh' => $diagioihanhchinh,
                'dienbien' => $dienbien
            ]);
    }

    /**
     * Creates a new CaytrongCanhtac model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id =  null)
    {
        $request = Yii::$app->request;
        $model = new CaytrongCanhtac(['diagioihanhchinh_id' => $id]);

        $categories['loaicaytrong'] = LoaiCayTrong::find()->where(['status' => 1])->all();

        $diagioihanhchinh = DiagioiHanhchinh::findOne($id);

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
            ->createCommand("UPDATE caytrong_canhtac SET geom = ST_SETSRID(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('".$model->geom_text."'))),4326) WHERE id = :id")
            ->bindValue(':id', $model->id)
            ->execute();

            return $this->redirect(['view', 'id' => $model->id]);
        }   

        return $this->render('create',[
            'model' => $model,
            'diagioihanhchinh' => $diagioihanhchinh,
            'categories' => $categories,
        ]);

    }

    /**
     * Updates an existing CaytrongCanhtac model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $categories['loaicaytrong'] = LoaiCayTrong::find()->where(['status' => 1])->all();

        $oldGeomGeojson = $model->geom_text;

        $diagioihanhchinh = DiagioiHanhchinh::findOne($model->diagioihanhchinh_id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->geom_text !== $oldGeomGeojson){
                $dataMap = $model->geom_text;

                $dataMap = json_decode($dataMap, true);
                $dataMap = array_values($dataMap);
                $dataMap = json_encode($dataMap, true);
                //dd(($dataMap));

                $geom_text = '{"type":"MultiPolygon","coordinates":'.$dataMap.'}';

                $model->geom_text = $geom_text;
            }

            Yii::$app->db->createCommand("UPDATE caytrong_canhtac SET geom = ST_SETSRID(ST_GeomFromText(ST_AsText(ST_GeomFromGeoJSON('".$model->geom_text."'))),4326) WHERE id = :id")
                ->bindValue(':id', $id)
                ->execute();

            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update',[
            'model' => $model,
            'diagioihanhchinh' => $diagioihanhchinh,
            'categories' => $categories,
        ]);
    }

    /**
     * Delete an existing CaytrongCanhtac model.
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
                    'title' => "Xóa vùng canh tác cây trồng",
                    'content' => '<span class="text-success">Xóa dữ liệu dữ liệuvùng canh tác cây trồng thành công</span>',
                    'forceReload' => '#crud-datatable-pjax',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Xóa dữ liệu vùng canh tác cây trồng" . $id,
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
     * Finds the CaytrongCanhtac model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CaytrongCanhtac the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CaytrongCanhtac::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
