<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\ThongTinBenh;
use app\modules\quanly\models\ThongTinBenhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\quanly\models\LoaiCayTrong;
use app\modules\danhmuc\models\DmThuocbaove;

/**
 * ThongTinBenhController implements the CRUD actions for ThongTinBenh model.
 */
class ThongTinBenhController extends BaseController
{

    public $title = "Thông tin bệnh";

    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Thông tin bệnh',
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
     * Lists all ThongTinBenh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThongTinBenhSearch();
        $queryParams =Yii::$app->request->queryParams;
        $queryParams['ThongTinBenhSearch']['status'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ThongTinBenh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        $model = $this->findModel($id);

        $thuocbaoves = DmThuocbaove::find()->where(['in', 'id', json_decode($model->thuoc_bao_ve)])->all();

        $thuocbaove = [];

        foreach ($thuocbaoves as $i => $item){
            $thuocbaove[] = $item->ten;
        }

        $thuocbaove = implode(', ', $thuocbaove);

        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Thông tin bệnh #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                        'thuocbaove' => $thuocbaove,
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary float-left'])
                ];
        }else{
            return $this->render('view', [
                'model' => $model,
                'thuocbaove' => $thuocbaove,
            ]);
        }
    }

    /**
     * Creates a new ThongTinBenh model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new ThongTinBenh();

        $categories['loaicaytrong'] = LoaiCayTrong::find()->where(['status' => 1])->all();
        $categories['thuocbaove'] = DmThuocbaove::find()->where(['status' => 1])->all();

        if($model->load($request->post())){
            if($model->thuoc_bao_ve != null){
                $model->thuoc_bao_ve = json_encode($model->thuoc_bao_ve);
            }

            $model->save();

            return $this->redirect('index');

        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);

    }

    /**
     * Updates an existing ThongTinBenh model.
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
        $categories['thuocbaove'] = DmThuocbaove::find()->where(['status' => 1])->all();

        if($model->thuoc_bao_ve != null){
            $model->thuoc_bao_ve = json_decode($model->thuoc_bao_ve);
        }

        if($model->load($request->post())){
            if($model->thuoc_bao_ve != null){
                $model->thuoc_bao_ve = json_encode($model->thuoc_bao_ve);
            }

            $model->save();

            return $this->redirect('index');

        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Delete an existing ThongTinBenh model.
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
                    'title' => "Xóa thông tin bệnh",
                    'content' => '<span class="text-success">Xóa thông tin bệnh thành công</span>',
                    'forceReload' => '#crud-datatable-pjax',
                    'footer' => Html::button('Đóng', ['class' => 'btn btn-light float-end', 'data-bs-dismiss' => "modal"])
                ];
            } else {
                return [
                    'title' => "Xóa thông tin bệnh" . $id,
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
     * Finds the ThongTinBenh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ThongTinBenh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ThongTinBenh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
