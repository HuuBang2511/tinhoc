<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\NongHo;
use app\modules\quanly\models\NongHoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\danhmuc\models\DmPhuongxa;
use app\modules\danhmuc\models\DmQuanhuyen;
use app\modules\danhmuc\models\DmTinhthanh;
use app\modules\danhmuc\models\DmThuocbaove;
use app\modules\quanly\models\FormTimDuong;

use app\modules\base\BaseController;

use yii\web\UploadedFile;
use app\modules\base\UploadFile;

use app\modules\quanly\models\DienbienDichbenh;
use app\modules\quanly\models\ThongTinBenh;
use app\modules\quanly\models\CuahangThuocbaove;
use yii\db\Query;

/**
 * NongHoController implements the CRUD actions for NongHo model.
 */
class NongHoController extends BaseController
{

    public $title = "Nông Hộ";

    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Nông hộ',
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
     * Lists all NongHo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NongHoSearch();
        $queryParams =Yii::$app->request->queryParams;
        $queryParams['NongHoSearch']['status'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single NongHo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        $dienbien = DienbienDichbenh::find()->where(['nongho_id' => $id])->andWhere(['status' => 1])->orderBy('id DESC')->all();

        if($request->isAjax){
            //Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Nông Hộ #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary float-left','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
                'dienbien' => $dienbien
            ]);
        }
    }

    /**
     * Creates a new NongHo model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new NongHo();
        $upload = new UploadFile();

        $categories['phuongxa'] = DmPhuongxa::find()->all();
        $categories['quanhuyen'] = DmQuanhuyen::find()->all();
        $categories['tinhthanh'] = DmTinhthanh::find()->all();

        //dd($categories);

        if($model->load($request->post()) && $upload->load($request->post())){

            $model->dia_chi = $model->so_nha.', '.$model->ten_duong.', '.(($model->phuongxa_id != null)? $model->phuongxa->ten.', '.$model->phuongxa->quanhuyen->ten.', '.$model->phuongxa->quanhuyen->tinhthanh->ten : ''); 

            $model->save();

            if($model->geo_x != null && $model->geo_y != null){ 
                Yii::$app->db->createCommand("UPDATE nong_ho SET geom = ST_GeomFromText('POINT($model->geo_x"." "."$model->geo_y)', 4326) WHERE id = :id")
                ->bindValue(':id', $model->id)
                ->execute();
            }

            $upload->imageupload = UploadedFile::getInstance($upload, 'imageupload');
            if ($upload->imageupload != null) {
                if (strpos($upload->imageupload->name, "'") == true) {
                    $upload->imageupload->name = str_replace("'", "_", $upload->imageupload->name);
                }
                $model->url_hinhanh = 'uploads/files/nongho/' . $model->id . '/' . $upload->imageupload->baseName . '.' . $upload->imageupload->extension;
                $model->save();

                $path = 'uploads/files/nongho/' . $model->id . '/';
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
     * Updates an existing NongHo model.
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

        $categories['phuongxa'] = DmPhuongxa::find()->all();
        $categories['quanhuyen'] = DmQuanhuyen::find()->all();
        $categories['tinhthanh'] = DmTinhthanh::find()->all();

        //dd($categories);

        if($model->load($request->post()) && $upload->load($request->post())){

            $upload->imageupload = UploadedFile::getInstance($upload, 'imageupload');
            
            if ($upload->imageupload != null) {
                if (strpos($upload->imageupload->name, "'") == true) {
                    $upload->imageupload->name = str_replace("'", "_", $upload->imageupload->name);
                }
                $model->url_hinhanh = 'uploads/files/nongho/' . $model->id . '/' . $upload->imageupload->baseName . '.' . $upload->imageupload->extension;

                $path = 'uploads/files/nongho/' . $model->id . '/';
                $upload->uploadFile($path, $upload->imageupload);
            }

            $model->dia_chi = $model->so_nha.', '.$model->ten_duong.', '.(($model->phuongxa_id != null)? $model->phuongxa->ten.', '.$model->phuongxa->quanhuyen->ten.', '.$model->phuongxa->quanhuyen->tinhthanh->ten : ''); 

            $model->save();

            if($model->geo_x != null && $model->geo_y != null){
                Yii::$app->db->createCommand("UPDATE nong_ho SET geom = ST_GeomFromText('POINT($model->geo_x"." "."$model->geo_y)', 4326) WHERE id = :id")
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
     * Delete an existing NongHo model.
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
                    'title' => "Xóa nông hộ",
                    'content' => '<span class="text-success">Xóa dữ liệu nông hộ thành công</span>',
                    'forceReload' => '#crud-datatable-pjax',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Xóa dữ liệu nông hộ" . $id,
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

    public function actionFindMap(){
        $this->title = 'Tìm đường';

        $nongho = null;
        $cuahangTim = null;

        $request = Yii::$app->request;
        
        $model = new FormTimduong();

        $categories['nongho'] = NongHo::find()->where(['status' => 1])->all();
        $categories['loaibenh'] = ThongTinBenh::find()->where(['status' => 1])->all();

        $queryParams['FormTimduong'] = $request->queryParams;
        $model->load($queryParams);

        //dd($categories);

        if($request->isPost && $model->load($request->post()))
        {   
            return $this->redirect([
                'find-map',
                'nongho_id' => $model->nongho_id,
                'loaibenh_id' => $model->loaibenh_id,
                'categories' => $categories,
            ]);
            
            // return $this->render('detail',[
            //     'model' => $model->FindMap(),
            // ]);
        }

        if($queryParams['FormTimduong'] != null) {
            $nongho = NongHo::findOne($model->nongho_id);
            $cuahang = CuaHangThuocbaove::find()->where(['status' => 1])->all();

            $cuahangThuoc = [];

            foreach ($cuahang as $i => $item){
                if($item->thuoc_bao_ve != null){
                    $thuocbaove = json_decode($item->thuoc_bao_ve);
                    if(in_array($model->loaibenh_id, $thuocbaove)){
                        $cuahangThuoc[] = $item;
                    }

                }
            }

            if(count($cuahangThuoc) > 0 && $nongho->geo_y != null && $nongho->geo_x != null){

                $khoangcach = [];

                foreach ($cuahangThuoc as $i => $item){
                    if($item->geo_x != null && $item->geo_y != null){
                        $dist = (new Query())->select(['ST_Distance(st_transform(st_setsrid(st_makepoint(' . $item->geo_x . ',' . $item->geo_y . '), 4326), 32648),st_transform(st_setsrid(st_makepoint(' . $nongho->geo_x . ',' . $nongho->geo_y . '), 4326), 32648)) as dist'])->from('nong_ho')->one();

                        $khoangcach[$item->id] = $dist['dist'];
                    }
                }

                $cuahang_id = array_search(min($khoangcach), $khoangcach);

                $cuahangTim = CuahangThuocbaove::findOne($cuahang_id);

                //dd(($cuahang_id));
            }else{
                $cuahangTim = null;
            }
        }

        return $this->render('find-map',[
            'model' => $model,
            'categories' => $categories,
            'nongho' => $nongho,
            'cuahangTim' => $cuahangTim,
        ]);
    }

    
    /**
     * Finds the NongHo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NongHo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NongHo::findOne($id)) !== null) {
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
