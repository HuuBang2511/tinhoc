<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\GiaoVien;
use app\modules\quanly\models\GiaoVienSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\danhmuc\models\DmGioitinh;
use app\modules\danhmuc\models\DmTrinhdo;
use app\modules\quanly\models\LichHoc;


/**
 * GiaoVienController implements the CRUD actions for GiaoVien model.
 */
class GiaoVienController extends BaseController
{

    public $title = "GiaoVien";

    public $const;

    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Giáo viên',
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
     * Lists all GiaoVien models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GiaoVienSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single GiaoVien model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        
        $model = $this->findModel($id);

        // $hocvienLophoc = HocvienLophoc::find()->where(['hocvien_id' => $id, 'status' => 1])->all();

        // $lophoc_id = [];
        // if($hocvienLophoc != null){
        //     foreach($hocvienLophoc as $i => $item){
        //         $lophoc_id[] = $item->lophoc_id;
        //     }
        // }

        $lichhoc = LichHoc::find()->where(['status' => 1, 'giaovien_id' => $id])->orderBy('thutrongtuan')->all();

        // $diemdanh = DiemDanh::find()->where(['status' => 1, 'hocvien_id' => $id])->all();
        
        return $this->render('view',[
            'model' => $model,
            'lichhoc' => $lichhoc,
            // 'diemdanh' => $diemdanh,
        ]);
    }

    /**
     * Creates a new GiaoVien model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new GiaoVien();
        $gioitinh = DmGioitinh::find()->where(['status' => 1])->all();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới giáo viên",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới giáo viên",
                    'content'=>'<span class="text-success">Thêm mới giáo viên thành công</span>',
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm mới',['create'],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Create new GiaoVien",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
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
                ]);
            }
        }

    }

    /**
     * Updates an existing GiaoVien model.
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

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật giáo viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                 return [
                    'title'=> "Cập nhật giáo viên #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                        'gioitinh' => $gioitinh,
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
                ]);
            }
        }
    }

    /**
     * Delete an existing GiaoVien model.
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
                'title' => "Xoá thông tin giáo viên #" . $id,
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
     * Finds the GiaoVien model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GiaoVien the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GiaoVien::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
