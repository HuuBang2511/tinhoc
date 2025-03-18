<?php

namespace app\modules\quanly\controllers;

use Yii;
use app\modules\quanly\models\DienbienDichbenh;
use app\modules\quanly\models\DienbienDichbenhSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\modules\base\BaseController;
use app\modules\quanly\models\ThongTinBenh;
use app\modules\quanly\models\NongHo;
use app\modules\quanly\models\CaytrongCanhtac;

/**
 * BienbienDichbenhController implements the CRUD actions for DienbienDichbenh model.
 */
class DienbienDichbenhController extends Controller
{

    public $const;
    public $STATUS = [
        'ACTIVE' => 1,
        'DELETED' => 0,
    ];


    public function init(){
        parent::init();
            $this->const = [
            'title' => 'Diễn biến dịch bệnh',
            'label' => [
                'index' => 'Danh sách',
                'create' => 'Thêm mới',
                'create-dichbenh-nongho' => 'Thêm mới',
                'update' => 'Cập nhật',
                'update-dichbenh-nongho' => 'Cập nhật',
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
     * Lists all DienbienDichbenh models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DienbienDichbenhSearch();
        $queryParams = Yii::$app->request->queryParams;
        $queryParams['DienbienDichbenhSearch']['status'] = 1;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single DienbienDichbenh model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Diễn biến dịch bệnh #".$id,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Đóng',['class'=>'btn btn-light float-right','data-bs-dismiss'=>"modal"]).
                            Html::a('Cập nhật',['update','id'=>$id],['class'=>'btn btn-primary float-left'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new DienbienDichbenh model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null)
    {
        $request = Yii::$app->request;
        $model = new DienbienDichbenh(['caytrongcanhtac_id' => $id]);

        $categories['thongtinbenh'] = ThongTinBenh::find()->where(['status' => 1])->all();
        $categories['nongho'] = NongHo::find()->where(['status' => 1])->all();

        if($model->load($request->post())){
            $model->save();

            return $this->redirect(['caytrong-canhtac/view', 'id' => $model->caytrongcanhtac_id]);
        }   

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories
        ]);

    }

    public function actionCreateDichbenhNongho($id = null)
    {
        $request = Yii::$app->request;
        $model = new DienbienDichbenh(['nongho_id' => $id]);

        $categories['thongtinbenh'] = ThongTinBenh::find()->where(['status' => 1])->all();

        $dienbiens = DienbienDichbenh::find()->select('caytrongcanhtac_id')->where('caytrongcanhtac_id is not null')->andWhere(['status' => 1])->asArray()->all();

        $dienbien = [];

        foreach ($dienbiens as $i => $item){
            $dienbien[] = $item['caytrongcanhtac_id'];
        }

        $categories['vungcaytrong'] = CaytrongCanhtac::find()->where(['status' => 1])->andWhere(['not in', 'id', $dienbien])->all();

        if($model->load($request->post())){
            $model->save();

            return $this->redirect(['nong-ho/view', 'id' => $model->nongho_id]);
        }   

        return $this->render('create-dichbenh-nongho', [
            'model' => $model,
            'categories' => $categories
        ]);

    }

    /**
     * Updates an existing DienbienDichbenh model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $categories['thongtinbenh'] = ThongTinBenh::find()->where(['status' => 1])->all();
        $categories['nongho'] = NongHo::find()->where(['status' => 1])->all();

        if($model->load($request->post())){
            $model->save();
            return $this->redirect(['caytrong-canhtac/view', 'id' => $model->caytrongcanhtac_id]); 
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories
        ]);
    }


    public function actionUpdateDichbenhNongho($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        $categories['thongtinbenh'] = ThongTinBenh::find()->where(['status' => 1])->all();
        
        // $dienbiens = DienbienDichbenh::find()->select('caytrongcanhtac_id')->where('caytrongcanhtac_id is not null')->asArray()->all();

        // $dienbien = [];

        // foreach ($dienbiens as $i => $item){
        //     $dienbien[] = $item['caytrongcanhtac_id'];
        // }

        // $categories['vungcaytrong'] = CaytrongCanhtac::find()->where(['status' => 1])->andWhere(['not in', 'id', $dienbien])->all();

        if($model->load($request->post())){
            $model->save();
            return $this->redirect(['nong-ho/view', 'id' => $model->nongho_id]); 
        }

        return $this->render('update-dichbenh-nongho', [
            'model' => $model,
            'categories' => $categories
        ]);
    }

    /**
     * Delete an existing DienbienDichbenh model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $model->status = 0;

        $model->save();
        return $this->redirect(['caytrong-canhtac/view', 'id' => $model->caytrongcanhtac_id]);
    }

    
    /**
     * Finds the DienbienDichbenh model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DienbienDichbenh the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DienbienDichbenh::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
 