<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\LopHoc;
use app\modules\quanly\models\LopHocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\danhmuc\models\DmTinhtranglophoc;
use app\modules\danhmuc\models\DmTinhtranghocphi;
use app\modules\danhmuc\models\DmTinhtranghoanthanh;
use app\modules\quanly\models\KhoaHoc;
use app\modules\quanly\models\HocvienLophoc;
use app\modules\quanly\models\VHocvien;
use app\modules\quanly\models\LichHoc;
use app\modules\quanly\models\DiemDanh;
use app\modules\quanly\models\KetQua;

/**
 * LopHocController implements the CRUD actions for LopHoc model.
 */
class LopHocController extends BaseController
{

    public $title = "Lớp học";

    public $const;

    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Lớp học',
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
     * Lists all LopHoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LopHocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tinhtranglophoc = DmTinhtranglophoc::find()->where(['status' => 1])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tinhtranglophoc' => $tinhtranglophoc,

        ]);
    }


    /**
     * Displays a single LopHoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $hocvienLophoc = HocvienLophoc::find()->where(['status' => 1, 'lophoc_id' => $id])->all();
        $lichhoc = LichHoc::find()->where(['status' => 1 , 'lophoc_id' => $id])->all();
        $diemdanh = DiemDanh::find()->where(['status' => 1, 'lophoc_id' => $id])->all();

        return $this->render('view',[
            'model' => $model,
            'hocvienLophoc' => $hocvienLophoc,
            'lichhoc' => $lichhoc,
            'diemdanh' => $diemdanh,
        ]);
    }

    public function actionDiemdanh($id)
    {
        $request = Yii::$app->request;
        $model = new DiemDanh(['lophoc_id' => $id]);
        $hocvien_id = HocvienLophoc::find()->select('hocvien_id')->where(['lophoc_id' => $id, 'status' => 1])->asArray()->all();
        $hocvienArr = [];
        if($hocvien_id != null){
            foreach($hocvien_id as $i => $item){
                $hocvienArr[] = $item['hocvien_id']; 
            }
        }
        
        $hocvien = VHocvien::find()->where(['in', 'id', $hocvienArr])->all();
        //dd($hocvien);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Điểm danh học sinh nghỉ học thuộc lớp học",
                    'content'=>$this->renderAjax('diemdanh', [
                        'model' => $model,
                        'hocvien' => $hocvien,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    //'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Điểm danh học sinh nghỉ học thuộc lớp học",
                    'content'=>'<span class="text-success">Điểm danh thành công</span>',
                    'footer'=> Html::a('Đóng',['view', 'id' => $id],['class'=>'btn btn-light float-right']).
                            Html::a('Tiếp tục điểm danh',['diemdanh', 'id' => $id],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Create new LopHoc",
                    'content'=>$this->renderAjax('diemdanh', [
                        'model' => $model,
                        'hocvien' => $hocvien,
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
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('diemdanh', [
                    'model' => $model,
                    'hocvien' => $hocvien,
                ]);
            }
        }

    }

    public function actionKetqua($id, $hocvien_id)
    {
        $request = Yii::$app->request;
        $model = KetQua::find()->where(['status' => 1, 'hocvien_id' => $hocvien_id, 'lophoc_id' => $id])->one();
        $hocvienlophoc = HocvienLophoc::find()->where(['status' => 1, 'hocvien_id' => $hocvien_id, 'lophoc_id' => $id])->one();;

        if($model == null){
            $model = new KetQua(['lophoc_id' => $id]);
            $model->hocvien_id = $hocvien_id;
            $model->tinhtranghoanthanh_id = $hocvienlophoc->tinhtranghoanthanh_id;
        }else{
            $model->tinhtranghoanthanh_id = $hocvienlophoc->tinhtranghoanthanh_id;
        }

        //dd($model);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Kết quả của học sinh",
                    'content'=>$this->renderAjax('ketqua', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post())){
                $model->save();
                if(!$model->save()){
                    echo ($model->getErrors());
                }
                return [
                    //'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Kết quả của học sinh",
                    'content'=>'<span class="text-success">Cập nhật kết quả thành công</span>',
                    'footer'=> Html::a('Đóng',['view', 'id' => $id],['class'=>'btn btn-light float-right'])
                            
                ];
            }
            else{
                return [
                    'title'=> "Create new LopHoc",
                    'content'=>$this->renderAjax('ketqua', [
                        'model' => $model,
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
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('ketqua', [
                    'model' => $model,
                ]);
            }
        }


    }

    public function actionCapnhatDiemdanh($id)
    {
        $request = Yii::$app->request;
        $model = DiemDanh::findOne($id);
        $hocvien_id = HocvienLophoc::find()->select('hocvien_id')->where(['lophoc_id' => $model->lophoc_id, 'status' => 1])->asArray()->all();
        $hocvienArr = [];
        if($hocvien_id != null){
            foreach($hocvien_id as $i => $item){
                $hocvienArr[] = $item['hocvien_id']; 
            }
        }
        
        $hocvien = VHocvien::find()->where(['in', 'id', $hocvienArr])->all();
        //dd($hocvien);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Điểm danh học sinh nghỉ học thuộc lớp học",
                    'content'=>$this->renderAjax('capnhat-diemdanh', [
                        'model' => $model,
                        'hocvien' => $hocvien,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    //'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Điểm danh học sinh nghỉ học thuộc lớp học",
                    'content'=>'<span class="text-success">Cập nhật thành công</span>',
                    'footer'=> Html::a('Đóng',['view', 'id' => $model->lophoc_id],['class'=>'btn btn-light float-right'])
                            
                ];
            }else{
                return [
                    'title'=> "Create new LopHoc",
                    'content'=>$this->renderAjax('capnhat-diemdanh', [
                        'model' => $model,
                        'hocvien' => $hocvien,
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
                return $this->redirect(['view', 'id' => $model->lophoc_id]);
            } else {
                return $this->render('capnhat-diemdanh', [
                    'model' => $model,
                    'hocvien' => $hocvien,
                ]);
            }
        }

    }

    public function actionXoadiemdanh($id)
    {
        $request = Yii::$app->request;
        $model = DiemDanh::findOne($id);

        $model->status = 0;
        $model->save();

        return $this->redirect(['view', 'id' => $model->lophoc_id]);

    }

    public function actionThemhocvien($id)
    {
        $request = Yii::$app->request;
        $model = new HocvienLophoc(['lophoc_id' => $id]);
        $tinhtranghocphi = DmTinhtranghocphi::find()->where(['status' => 1])->all();
        $tinhtranghoanthanh = DmTinhtranghoanthanh::find()->where(['status' => 1])->all();
        $hocvien = VHocvien::find()->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới học viên vào lớp học",
                    'content'=>$this->renderAjax('themhocvien', [
                        'model' => $model,
                        'tinhtranghocphi' => $tinhtranghocphi,
                        'hocvien' => $hocvien,
                        'tinhtranghoanthanh' => $tinhtranghoanthanh,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    //'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới học viên vào lớp học",
                    'content'=>'<span class="text-success">Thêm mới học viên vào lớp học thành công</span>',
                    'footer'=> Html::a('Đóng',['view', 'id' => $id],['class'=>'btn btn-light float-right']).
                            Html::a('Tiếp tục thêm mới',['themhocvien', 'id' => $id],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Create new LopHoc",
                    'content'=>$this->renderAjax('themhocvien', [
                        'model' => $model,
                        'tinhtranghocphi' => $tinhtranghocphi,
                        'hocvien' => $hocvien,
                        'tinhtranghoanthanh' => $tinhtranghoanthanh,
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
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('themhocvien', [
                    'model' => $model,
                    'tinhtranghocphi' => $tinhtranghocphi,
                    'hocvien' => $hocvien,
                    'tinhtranghoanthanh' => $tinhtranghoanthanh,
                ]);
            }
        }

    }

    public function actionCapnhathocvien($id)
    {
        $request = Yii::$app->request;
        $model = HocvienLophoc::findOne($id);
        $tinhtranghocphi = DmTinhtranghocphi::find()->where(['status' => 1])->all();
        $tinhtranghoanthanh = DmTinhtranghoanthanh::find()->where(['status' => 1])->all();
        $hocvien = VHocvien::find()->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật học viên lớp học",
                    'content'=>$this->renderAjax('themhocvien', [
                        'model' => $model,
                        'tinhtranghocphi' => $tinhtranghocphi,
                        'hocvien' => $hocvien,
                        'tinhtranghoanthanh' => $tinhtranghoanthanh,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    //'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Cập nhật học viên lớp học",
                    'content'=>'<span class="text-success">Cập nhật học viên lớp học thành công</span>',
                    'footer'=> Html::a('Đóng',['view', 'id' => $model->lophoc_id],['class'=>'btn btn-light float-right'])
                ];
            }else{
                return [
                    'title'=> "Create new LopHoc",
                    'content'=>$this->renderAjax('themhocvien', [
                        'model' => $model,
                        'tinhtranghocphi' => $tinhtranghocphi,
                        'hocvien' => $hocvien,
                        'tinhtranghoanthanh' => $tinhtranghoanthanh,
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
                return $this->redirect(['view', 'id' => $id]);
            } else {
                return $this->render('themhocvien', [
                    'model' => $model,
                    'tinhtranghocphi' => $tinhtranghocphi,
                    'hocvien' => $hocvien,
                    'tinhtranghoanthanh' => $tinhtranghoanthanh,
                ]);
            }
        }

    }

    public function actionXoahocvien($id)
    {
        $request = Yii::$app->request;
        $model = HocvienLophoc::findOne($id);

        $model->status = 0;
        $model->save();

        return $this->redirect(['view', 'id' => $model->lophoc_id]);

    }

    /**
     * Creates a new LopHoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new LopHoc();
        $tinhtranglophoc = DmTinhtranglophoc::find()->where(['status' => 1])->all();
        $khoahoc = KhoaHoc::find()->where(['status' => 1])->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới thông tin lớp học",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'tinhtranglophoc' => $tinhtranglophoc,
                        'khoahoc' => $khoahoc,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới thông tin lớp học",
                    'content'=>'<span class="text-success">Thêm mới thông tin lớp học thành công</span>',
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm mới',['create'],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Create new LopHoc",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'tinhtranglophoc' => $tinhtranglophoc,
                        'khoahoc' => $khoahoc,
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
                    'tinhtranglophoc' => $tinhtranglophoc,
                    'khoahoc' => $khoahoc,
                ]);
            }
        }

    }

    /**
     * Updates an existing LopHoc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $tinhtranglophoc = DmTinhtranglophoc::find()->where(['status' => 1])->all();
        $khoahoc = KhoaHoc::find()->where(['status' => 1])->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật LopHoc #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'tinhtranglophoc' => $tinhtranglophoc,
                        'khoahoc' => $khoahoc,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                 return [
                    'title'=> "Cập nhật LopHoc #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'tinhtranglophoc' => $tinhtranglophoc,
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
                    'tinhtranglophoc' => $tinhtranglophoc,
                    'khoahoc' => $khoahoc,
                ]);
            }
        }
    }

    /**
     * Delete an existing LopHoc model.
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
                'title' => "Xoá khóa học #" . $id,
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
     * Finds the LopHoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LopHoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LopHoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
