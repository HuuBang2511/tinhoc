<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\HocVien;
use app\modules\quanly\models\HocVienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\danhmuc\models\DmGioitinh;
use app\modules\danhmuc\models\DmTrinhdo;
use app\modules\base\BaseController;
use app\modules\quanly\models\HocVienLophoc;
use app\modules\quanly\models\LichHoc;
use app\modules\quanly\models\DiemDanh;
use app\modules\quanly\models\HocPhi;
use app\modules\quanly\models\KetQua;
use app\modules\quanly\models\VKetquaTinhtrang;

/**
 * HocVienController implements the CRUD actions for HocVien model.
 */
class HocVienController extends BaseController
{

    public $title = "Học viên";

    public $const;

    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Học viên',
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
     * Lists all HocVien models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HocVienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single HocVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $hocvienLophoc = HocvienLophoc::find()->where(['hocvien_id' => $id, 'status' => 1])->all();

        $lophoc_id = [];
        if($hocvienLophoc != null){
            foreach($hocvienLophoc as $i => $item){
                $lophoc_id[] = $item->lophoc_id;
            }
        }

        $lichhoc = LichHoc::find()->where(['lich_hoc.status' => 1])
        ->innerJoin('lop_hoc', 'lop_hoc.id = lich_hoc.lophoc_id')
        ->andWhere(['lop_hoc.tinhtranglophoc_id' => 1])
        ->andWhere(['in', 'lich_hoc.lophoc_id', $lophoc_id])->all();

        $diemdanh = DiemDanh::find()->where(['status' => 1, 'hocvien_id' => $id])->all();

        $hocphi = HocPhi::find()->where(['status' => 1, 'hocvien_id' => $id])->all();

        $ketqua = VKetquaTinhtrang::find()
        ->where(['hocvien_id' => $id])->all();

        //dd($ketqua);
        
        return $this->render('view',[
            'model' => $model,
            'lichhoc' => $lichhoc,
            'diemdanh' => $diemdanh,
            'hocphi' => $hocphi,
            'ketqua' => $ketqua,
        ]);
    }

    /**
     * Creates a new HocVien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new HocVien();
        $gioitinh = DmGioitinh::find()->where(['status' => 1])->all();
        $trinhdo = DmTrinhdo::find()->where(['status' => 1])->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới học viên",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
                        'trinhdo' => $trinhdo,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới HocVien",
                    'content'=>'<span class="text-success">Thêm mới HocVien thành công</span>',
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm mới',['create'],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Create new HocVien",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
                        'trinhdo' => $trinhdo,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"])

                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'gioitinh' => $gioitinh,
                    'trinhdo' => $trinhdo,
                ]);
            }
        }

    }

    /**
     * Updates an existing HocVien model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $gioitinh = DmGioitinh::find()->where(['status' => 1])->all();
        $trinhdo = DmTrinhdo::find()->where(['status' => 1])->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật thông tin học viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
                        'trinhdo' => $trinhdo,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                 return [
                    'title'=> "Cập nhật học viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
                        'trinhdo' => $trinhdo,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"])
                ];
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'gioitinh' => $gioitinh,
                    'trinhdo' => $trinhdo,
                ]);
            }
        }
    }

    /**
     * Delete an existing HocVien model.
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
                return [
                'title' => "Xoá thông tin học viên #" . $id,
                'content' => $this->renderAjax('delete', [
                'model' => $model,
                ]),
                ];
        } else {
            $model->status = 0;
            $model->save();
            return $this->redirect(['index']);
        }
    }

    
    /**
     * Finds the HocVien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HocVien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HocVien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
