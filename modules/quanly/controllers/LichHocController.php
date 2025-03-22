<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\Lichhoc;
use app\modules\quanly\models\LichhocSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\quanly\models\PhongHoc;
use app\modules\quanly\models\LopHoc;
use app\modules\quanly\models\GiaoVien;

/**
 * LichHocController implements the CRUD actions for Lichhoc model.
 */
class LichHocController extends BaseController
{

    public $title = "Lịch học";

    public $const;

    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Lịch học',
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
     * Lists all Lichhoc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $phonghoc = PhongHoc::find()->where(['status' => 1])->all();
        $giaovien = GiaoVien::find()->where(['status' => 1])->all();
        $lophoc = Lophoc::find()->where(['status' => 1])->all();

        $thu = [
            1 => 'Chủ nhật',
            2 => 'Thứ 2',
            3 => 'Thứ 3',
            4 => 'Thứ 4',
            5 => 'Thứ 5',
            6 => 'Thứ 6',
            7 => 'Thứ 7',
        ];

        $gio = [
            8 => '8:00',
            9 => '9:00',
            10 => '10:00',
            11 => '11:00',
            12 => '12:00',
            13 => '13:00',
            14 => '14:00',
            15 => '15:00',
            16 => '16:00',
            17 => '17:00',
            18 => '18:00',
            19 => '19:00',
            20 => '20:00',
            21 => '21:00',
            22 => '22:00',
            23 => '23:00',
        ];

        $searchModel = new LichhocSearch();
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'phonghoc' => $phonghoc,
            'giaovien' => $giaovien,
            'lophoc' => $lophoc,
            'thu' => $thu,
            'gio' => $gio,
        ]);
    }


    /**
     * Displays a single Lichhoc model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Lichhoc #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Lichhoc model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Lichhoc();
        $phonghoc = PhongHoc::find()->where(['status' => 1])->all();
        $giaovien = GiaoVien::find()->where(['status' => 1])->all();
        $lophoc = Lophoc::find()->where(['status' => 1])->all();

        $thu = [
            1 => 'Chủ nhật',
            2 => 'Thứ 2',
            3 => 'Thứ 3',
            4 => 'Thứ 4',
            5 => 'Thứ 5',
            6 => 'Thứ 6',
            7 => 'Thứ 7',
        ];

        $gio = [
            8 => '8:00',
            9 => '9:00',
            10 => '10:00',
            11 => '11:00',
            12 => '12:00',
            13 => '13:00',
            14 => '14:00',
            15 => '15:00',
            16 => '16:00',
            17 => '17:00',
            18 => '18:00',
            19 => '19:00',
            20 => '20:00',
            21 => '21:00',
            22 => '22:00',
            23 => '23:00',
        ];

        if($model->load($request->post())){
            $model->save();
            
            return $this->redirect('index');
        }

        return $this->render('create', [
            'model' => $model,
            'phonghoc' => $phonghoc,
            'giaovien' => $giaovien,
            'lophoc' => $lophoc,
            'thu' => $thu,
            'gio' => $gio,
        ]);
    }

    /**
     * Updates an existing Lichhoc model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $phonghoc = PhongHoc::find()->where(['status' => 1])->all();
        $giaovien = GiaoVien::find()->where(['status' => 1])->all();
        $lophoc = Lophoc::find()->where(['status' => 1])->all();

        $thu = [
            1 => 'Chủ nhật',
            2 => 'Thứ 2',
            3 => 'Thứ 3',
            4 => 'Thứ 4',
            5 => 'Thứ 5',
            6 => 'Thứ 6',
            7 => 'Thứ 7',
        ];

        $gio = [
            8 => '8:00',
            9 => '9:00',
            10 => '10:00',
            11 => '11:00',
            12 => '12:00',
            13 => '13:00',
            14 => '14:00',
            15 => '15:00',
            16 => '16:00',
            17 => '17:00',
            18 => '18:00',
            19 => '19:00',
            20 => '20:00',
            21 => '21:00',
            22 => '22:00',
            23 => '23:00',
        ];

        if($model->load($request->post())){
            $model->save();
            
            return $this->redirect('index');
        }

        return $this->render('update', [
            'model' => $model,
            'phonghoc' => $phonghoc,
            'giaovien' => $giaovien,
            'lophoc' => $lophoc,
            'thu' => $thu,
            'gio' => $gio,
        ]);
    }

    /**
     * Delete an existing Lichhoc model.
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
                'title' => "Xoá lịch học #" . $id,
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
     * Finds the Lichhoc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lichhoc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lichhoc::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
