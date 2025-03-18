<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\CuahangThuocbaove;
use app\modules\quanly\models\CuahangThuocbaoveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\danhmuc\models\DmThuocbaove;
use app\modules\danhmuc\models\DmPhuongxa;
use app\modules\danhmuc\models\DmQuanhuyen;
use app\modules\danhmuc\models\DmTinhthanh;
use yii\web\UploadedFile;
use app\modules\base\UploadFile;

/**
 * CuahangThuocbaoveController implements the CRUD actions for CuahangThuocbaove model.
 */
class CuahangThuocbaoveController extends BaseController
{

    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Cửa hàng thuốc bảo vệ',
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
     * Lists all CuahangThuocbaove models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CuahangThuocbaoveSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['CuahangThuocbaoveSearch']['status'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single CuahangThuocbaove model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        if($model->thuoc_bao_ve != null){
            $thuocbaoves = DmThuocbaove::find()->where(['in', 'id', json_decode($model->thuoc_bao_ve)])->all();
            $thuocbaove = [];

            foreach ($thuocbaoves as $i => $item){
                $thuocbaove[] = $item->ten;
            }

            $thuocbaove = implode(', ', $thuocbaove);
        }else{
            $thuocbaove = null;
        }
        

        

        if($request->isAjax){
            //Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "CuahangThuocbaove #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                        'thuocbaove' => $thuocbaove
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $model,
                'thuocbaove' => $thuocbaove,
            ]);
        }
    }

    /**
     * Creates a new CuahangThuocbaove model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new CuahangThuocbaove();
        $upload = new UploadFile();

        $categories['thuocbaove'] = DmThuocbaove::find()->where(['status' => 1])->all();
        $categories['phuongxa'] = DmPhuongxa::find()->all();
        $categories['quanhuyen'] = DmQuanhuyen::find()->all();
        $categories['tinhthanh'] = DmTinhthanh::find()->all();

        if($model->load($request->post()) && $upload->load($request->post())){
            if($model->thuoc_bao_ve != null){
                $model->thuoc_bao_ve = json_encode($model->thuoc_bao_ve);
            }

            $model->dia_chi = $model->so_nha.', '.$model->ten_duong.', '.(($model->phuongxa_id != null)? $model->phuongxa->ten.', '.$model->phuongxa->quanhuyen->ten.', '.$model->phuongxa->quanhuyen->tinhthanh->ten : ''); 

            $model->save();

            if($model->geo_x != null && $model->geo_y != null){
                Yii::$app->db->createCommand("UPDATE cuahang_thuocbaove SET geom = ST_GeomFromText('POINT($model->geo_x"." "."$model->geo_y)', 4326) WHERE id = :id")
                ->bindValue(':id', $model->id)
                ->execute();
            }

            $upload->imageupload = UploadedFile::getInstance($upload, 'imageupload');
            if ($upload->imageupload != null) {
                if (strpos($upload->imageupload->name, "'") == true) {
                    $upload->imageupload->name = str_replace("'", "_", $upload->imageupload->name);
                }
                $model->url_hinhanh = 'uploads/files/cuahang/' . $model->id . '/' . $upload->imageupload->baseName . '.' . $upload->imageupload->extension;
                $model->save();

                $path = 'uploads/files/cuahang/' . $model->id . '/';
                $upload->uploadFile($path, $upload->imageupload);
            }

            return $this->redirect(['view', 'id' => $model->id]);

        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
            'upload' => $upload,
        ]);

    }

    /**
     * Updates an existing CuahangThuocbaove model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $upload = new UploadFile();

        

        $categories['thuocbaove'] = DmThuocbaove::find()->where(['status' => 1])->all();
        $categories['phuongxa'] = DmPhuongxa::find()->all();
        $categories['quanhuyen'] = DmQuanhuyen::find()->all();
        $categories['tinhthanh'] = DmTinhthanh::find()->all();

        if($model->thuoc_bao_ve != null){
            $model->thuoc_bao_ve = json_decode($model->thuoc_bao_ve);
        }

        if($model->load($request->post()) && $upload->load($request->post())){

          

            $upload->imageupload = UploadedFile::getInstance($upload, 'imageupload');
            
            if ($upload->imageupload != null) {
                if (strpos($upload->imageupload->name, "'") == true) {
                    $upload->imageupload->name = str_replace("'", "_", $upload->imageupload->name);
                }
                $model->url_hinhanh = 'uploads/files/cuahang/' . $model->id . '/' . $upload->imageupload->baseName . '.' . $upload->imageupload->extension;

                $path = 'uploads/files/cuahang/' . $model->id . '/';
                $upload->uploadFile($path, $upload->imageupload);
            }

            if($model->thuoc_bao_ve != null){
                $model->thuoc_bao_ve = json_encode($model->thuoc_bao_ve);
            }

            $model->dia_chi = $model->so_nha.', '.$model->ten_duong.', '.(($model->phuongxa_id != null)? $model->phuongxa->ten.', '.$model->phuongxa->quanhuyen->ten.', '.$model->phuongxa->quanhuyen->tinhthanh->ten : ''); 

            $model->save();

            if($model->geo_x != null && $model->geo_y != null){
                Yii::$app->db->createCommand("UPDATE cuahang_thuocbaove SET geom = ST_GeomFromText('POINT($model->geo_x"." "."$model->geo_y)', 4326) WHERE id = :id")
                ->bindValue(':id', $id)
                ->execute();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
            'upload' => $upload,
        ]);
    }

    /**
     * Delete an existing CuahangThuocbaove model.
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
                    'title' => "Xóa cửa hàng",
                    'content' => '<span class="text-success">Xóa cửa hàng thành công</span>',
                    'forceReload' => '#crud-datatable-pjax',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Xóa cửa hàng" . $id,
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
     * Finds the CuahangThuocbaove model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CuahangThuocbaove the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CuahangThuocbaove::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionQuanhuyen() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $tinhthanh_id = $parents[0];
                $out = DmQuanhuyen::find()->select('id, ten as name')
                    ->where(['tinhthanh_id' => $tinhthanh_id])
                    ->orderBy('ten')->asArray()->all();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }

    public function actionPhuongxa() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $ids = $_POST['depdrop_parents'];
            $quanhuyen_id = empty($ids[0]) ? null : $ids[0];
            if ($quanhuyen_id != null) {
                $out = DmPhuongxa::find()->select('id, ten as name')->where(['quanhuyen_id' => $quanhuyen_id])->orderBy('ten')->asArray()->all();
                return ['output'=>$out, 'selected'=>''];
            }
        }
        return ['output'=>'', 'selected'=>''];
    }
}
