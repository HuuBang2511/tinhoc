<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\PhongHoc;
use app\modules\quanly\models\PhongHocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\quanly\models\LichHoc;

/**
 * PhongHocController implements the CRUD actions for PhongHoc model.
 */
class PhongHocController extends BaseController
{

    public $title = "Phòng học";

    public $const;

    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Phòng học',
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
     * Lists all PhongHoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PhongHocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single PhongHoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $thoikhoabieu = [
            1 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
            2 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
            3 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
            4 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
            5 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
            6 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
            7 => [
                8 => null,
                9 => null,
                10 => null,
                11 => null,
                12 => null,
                13 => null,
                14 => null,
                15 => null,
                16 => null,
                17 => null,
                18 => null,
                19 => null,
                20 => null,
                21 => null,
                22 => null,
                23 => null,
            ],
        ];

        $lichhoc = LichHoc::find()
        ->leftJoin('lop_hoc', 'lop_hoc.id = lich_hoc.lophoc_id')
        ->Where(['lop_hoc.tinhtranglophoc_id' => 1])
        ->andwhere(['lich_hoc.status' => 1, 'lich_hoc.phonghoc_id' =>$id])->orderBy('thutrongtuan')->all();

        
        if($lichhoc != null){
            foreach($lichhoc as $i => $item){
                $khoangthoigian = $item->gioketthuc - $item->giobatdau;
                $thoikhoabieu[$item->thutrongtuan][$item->giobatdau] = 'Lớp: '.$item->lophoc->ma.', Khóa: '.$item->lophoc->khoahoc->ten;
                for($i=1 ; $i < $khoangthoigian; $i++){
                    $thoikhoabieu[$item->thutrongtuan][$item->giobatdau + $i] = 'Lớp: '.$item->lophoc->ma.', Khóa: '.$item->lophoc->khoahoc->ten;
                }
            } 
        }
          

        //dd($thoikhoabieu);

        return $this->render('view',[
            'model' => $model,
            'thoikhoabieu' => $thoikhoabieu,
        ]);
    }

    /**
     * Creates a new PhongHoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new PhongHoc();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Thêm mới phòng học",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"]).
                            Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Thêm mới phòng học",
                    'content'=>'<span class="text-success">Thêm mới phòng học thành công</span>',
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Tiếp tục thêm mới',['create'],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
            }else{
                return [
                    'title'=> "Create new PhongHoc",
                    'content'=>$this->renderAjax('create', [
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing PhongHoc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Cập nhật phòng học #".$id,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                                Html::button('Lưu',['class'=>'btn btn-primary float-left','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                 return [
                    'title'=> "Cập nhật phòng học #".$id,
                    'content'=>$this->renderAjax('update', [
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
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing PhongHoc model.
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
                'title' => "Xoá phòng học #" . $id,
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
     * Finds the PhongHoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PhongHoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PhongHoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
