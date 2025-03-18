<?php

namespace app\modules\danhmuc\controllers;

use Yii;
use app\modules\danhmuc\models\DmThuocbaove;
use app\modules\danhmuc\models\DmThuocbaoveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use yii\web\UploadedFile;
use app\modules\base\UploadFile;

/**
 * ThuocBaoveController implements the CRUD actions for DmThuocbaove model.
 */
class ThuocBaoveController extends BaseController
{

    public $title = "Thuốc bảo vệ";

    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Thuốc bảo vệ',
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
     * Lists all DmThuocbaove models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DmThuocbaoveSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['DmThuocbaoveSearch']['status'] = 1;
        $dataProvider = $searchModel->search( $queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single DmThuocbaove model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Thuốc bảo vệ #".$id,
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
     * Creates a new DmThuocbaove model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new DmThuocbaove();
        $upload = new UploadFile();


        if($model->load($request->post()) && $upload->load($request->post())){
            $model->save();

            $upload->imageupload = UploadedFile::getInstance($upload, 'imageupload');
            if ($upload->imageupload != null) {
                if (strpos($upload->imageupload->name, "'") == true) {
                    $upload->imageupload->name = str_replace("'", "_", $upload->imageupload->name);
                }
                $model->url_hinhanh = 'uploads/files/thuocbaove/' . $model->id . '/' . $upload->imageupload->baseName . '.' . $upload->imageupload->extension;
                $model->save();

                $path = 'uploads/files/thuocbaove/' . $model->id . '/';
                $upload->uploadFile($path, $upload->imageupload);
            }

            return $this->redirect('index');

        }

        return $this->render('create', [
            'model' => $model,
            'upload' => $upload,
        ]);

    }

    /**
     * Updates an existing DmThuocbaove model.
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


        if($model->load($request->post()) && $upload->load($request->post())){

            $upload->imageupload = UploadedFile::getInstance($upload, 'imageupload');
            if ($upload->imageupload != null) {
                if (strpos($upload->imageupload->name, "'") == true) {
                    $upload->imageupload->name = str_replace("'", "_", $upload->imageupload->name);
                }
                $model->url_hinhanh = 'uploads/files/thuocbaove/' . $model->id . '/' . $upload->imageupload->baseName . '.' . $upload->imageupload->extension;

                $path = 'uploads/files/thuocbaove/' . $model->id . '/';
                $upload->uploadFile($path, $upload->imageupload);
            }

            $model->save();

            return $this->redirect('index');

        }

        return $this->render('update', [
            'model' => $model,
            'upload' => $upload,
        ]);
    }

    /**
     * Delete an existing DmThuocbaove model.
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
                    'title' => "Xóa thuốc bảo vệ",
                    'content' => '<span class="text-success">Xóa thuốc bảo vệ thành công</span>',
                    'forceReload' => '#crud-datatable-pjax',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Xóa thuốc bảo vệ" . $id,
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
     * Finds the DmThuocbaove model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DmThuocbaove the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DmThuocbaove::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
