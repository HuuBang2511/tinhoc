<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\modules\base\Config;
use app\modules\base\Constant;
use app\modules\caytrong\models\Nongho;
use app\modules\caytrong\models\PgRanhthua;
use app\modules\channuoi\models\CosoNuoiheo;
use app\modules\danhmuc\models\DmCaytrong;
use app\modules\danhmuc\models\DmDoituongnuoi;
use app\modules\danhmuc\models\DmGap;
use app\modules\danhmuc\models\HcPhuong;
use app\modules\danhmuc\models\HcQuan;
use app\modules\thuysan\models\CosoNuoicalongbe;
use app\modules\thuysan\models\CosoNuoicatra;
use hcmgis\user\models\AuthUser;
use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $maquan = Config::getMaquan();

        $nonghoStatistic = Nongho::find()
            ->leftJoin('dientich_sx', 'dientich_sx.nongho_id = nongho.id')
            ->leftJoin('dm_caytrong', 'dm_caytrong.id = dientich_sx.loai_ctr_id')
            ->groupBy('dm_caytrong.id')
            ->where(['nongho.status' => Constant::STATUS_ACTIVE])
            ->andWhere(['not', ['loai_ctr_id' => null]])
            ->select(['dm_caytrong.ten', 'dm_caytrong.id', 'count(nongho_id)'])
            ->asArray()
            ->all();

        $nonghoCount = Nongho::find()->where(['status' => Constant::STATUS_ACTIVE])->count();

        $vietGAPCount = Nongho::find()
            ->leftJoin('dientich_sx', 'dientich_sx.nongho_id = nongho.id')
            ->where(['nongho.status' => Constant::STATUS_ACTIVE])
            ->andWhere(['ilike', 'ma_cn', 'VietGAP'])
            ->count();
        $truyenthongCount = $nonghoCount - $vietGAPCount;

        $quytrinhSanxuatStatistic = [
            'Truyền thống' => $truyenthongCount,
            'VietGAP' => $vietGAPCount,
        ];

        $dientichSanxuatStatistic = DmCaytrong::find()
            ->leftJoin('dientich_sx', 'dientich_sx.loai_ctr_id = dm_caytrong.id')
            ->innerJoin('nongho', 'nongho.id = dientich_sx.nongho_id AND nongho.status=' . Constant::STATUS_ACTIVE)
            ->where(['dm_caytrong.status' => Constant::STATUS_ACTIVE])
            ->andFilterWhere(['nongho.maquan' => $maquan])
            ->groupBy('dm_caytrong.id')
            ->select(['COALESCE(sum(dt_gt)::numeric, 0) as truyenthong', 'COALESCE(sum(dt_vg)::numeric, 0) as vietgap', 'dm_caytrong.ten'])
            ->asArray()
            ->all();

        if ($maquan) {
            $nonghoHanhchinhStatistic = HcPhuong::find()
                ->leftJoin('nongho', "nongho.maphuong = hc_phuong.maphuong AND nongho.status =" . Constant::STATUS_ACTIVE)
                ->leftJoin('dientich_sx', 'dientich_sx.nongho_id = nongho.id')
                ->where(['hc_phuong.maquan' => $maquan])
                ->groupBy('hc_phuong.id')
                ->select(['hc_phuong.tenphuong as ten', 'count(nongho.id) as soho, COALESCE(sum(dt_gt::numeric),0) + COALESCE(sum(dt_vg::numeric), 0) as dientich'])
                ->asArray()
                ->all();
        } else {
            $nonghoHanhchinhStatistic = HcQuan::find()
                ->leftJoin('nongho', "nongho.maquan = hc_quan.maquan AND nongho.status =" . Constant::STATUS_ACTIVE)
                ->leftJoin('dientich_sx', 'dientich_sx.nongho_id = nongho.id')
                ->groupBy('hc_quan.id')
                ->select(['hc_quan.tenquan as ten', 'count(nongho.id) as soho, COALESCE(sum(dt_gt + dt_vg)::numeric, 0) as dientich'])
                ->asArray()
                ->all();
        }


        $cosoCatraCount = CosoNuoicatra::find()->where(['status' => Constant::STATUS_ACTIVE])->count();
        $cosoCatraStatistic = DmGap::find()
            ->leftJoin('coso_nuoicatra ct', 'ct.dm_gap_id = dm_gap.id AND ct.status=' . Constant::STATUS_ACTIVE)
            ->groupBy('dm_gap.id')
            ->select(['dm_gap.ten', 'count(ct.id)'])
            ->asArray()
            ->all();

        $cosoCalongbeCount = CosoNuoicalongbe::find()->where(['status' => Constant::STATUS_ACTIVE])->count();
        $cosoCalongbeStatistic = DmDoituongnuoi::find()
            ->leftJoin('coso_nuoicalongbe_doituongnuoi cd', 'cd.doituongnuoi_id = dm_doituongnuoi.id')
            ->leftJoin('coso_nuoicalongbe clb', 'clb.id = cd.coso_nuoica_id AND clb.status = ' . Constant::STATUS_ACTIVE)
            ->groupBy('dm_doituongnuoi.id')
            ->select(['dm_doituongnuoi.ten', 'count(clb.id)'])
            ->asArray()
            ->all();

        if ($maquan) {
            $catraPhuongxaQuery = HcPhuong::find()
                ->leftJoin('coso_nuoicatra cs', "cs.maphuong = hc_phuong.maphuong AND cs.status =" . Constant::STATUS_ACTIVE)
                ->where(['hc_phuong.maquan' => $maquan])
                ->groupBy('hc_phuong.id')
                ->select(['hc_phuong.id as phuongxa_id', 'hc_phuong.tenphuong as phuongxa', 'count(cs.id) as so_coso_catra']);
            $calongbePhuongxaQuery = HcPhuong::find()
                ->leftJoin('coso_nuoicalongbe cs', "cs.maphuong = hc_phuong.maphuong AND cs.status =" . Constant::STATUS_ACTIVE)
                ->where(['hc_phuong.maquan' => $maquan])
                ->groupBy('hc_phuong.id')
                ->select(['hc_phuong.id as phuongxa_id', 'hc_phuong.tenphuong as phuongxa', 'count(cs.id) as so_coso_calongbe']);
            $thuysanHanhchinhStatistic = (new Query())->from(['catra' => $catraPhuongxaQuery])
                ->innerJoin(['calongbe' => $calongbePhuongxaQuery], 'calongbe.phuongxa_id = catra.phuongxa_id')
                ->select(['catra.phuongxa as ten', 'so_coso_catra', 'so_coso_calongbe'])
                ->all();
        } else {
            $catraQuanhuyenQuery = HcQuan::find()
                ->leftJoin('coso_nuoicatra cs', "cs.maquan = hc_quan.maquan AND cs.status =" . Constant::STATUS_ACTIVE)
                ->groupBy('hc_quan.id')
                ->select(['hc_quan.id as quanhuyen_id', 'hc_quan.tenquan as quanhuyen', 'count(cs.id) as so_coso_catra']);
            $calongbeQuanhuyenQuery = HcQuan::find()
                ->leftJoin('coso_nuoicalongbe cs', "cs.maquan = hc_quan.maquan AND cs.status =" . Constant::STATUS_ACTIVE)
                ->groupBy('hc_quan.id')
                ->select(['hc_quan.id as quanhuyen_id', 'hc_quan.tenquan as quanhuyen', 'count(cs.id) as so_coso_calongbe']);
            $thuysanHanhchinhStatistic = (new Query())->from(['catra' => $catraQuanhuyenQuery])
                ->innerJoin(['calongbe' => $calongbeQuanhuyenQuery], 'calongbe.quanhuyen_id = catra.quanhuyen_id')
                ->select(['catra.quanhuyen as ten', 'so_coso_catra', 'so_coso_calongbe'])
                ->all();
        }


        $cosoNuoiheoCount = CosoNuoiheo::find()->where(['status' => Constant::STATUS_ACTIVE])->count();
        if ($maquan) {
            $channuoiHanhchinhStatistic = HcPhuong::find()
                ->leftJoin('coso_nuoiheo cs', "cs.maphuong = hc_phuong.maphuong AND cs.status =" . Constant::STATUS_ACTIVE)
                ->where(['hc_phuong.maquan' => $maquan])
                ->groupBy('hc_phuong.id')
                ->select(['hc_phuong.tenphuong as ten', 'count(cs.id) as so_coso_nuoiheo'])
                ->asArray()
                ->all();
        } else {
            $channuoiHanhchinhStatistic = HcQuan::find()
                ->leftJoin('coso_nuoiheo cs', "cs.maquan = hc_quan.maquan AND cs.status =" . Constant::STATUS_ACTIVE)
                ->groupBy('hc_quan.id')
                ->select(['hc_quan.tenquan as ten', 'count(cs.id) as so_coso_nuoiheo'])
                ->asArray()
                ->all();
        }


        $ranhthuaCount = PgRanhthua::find()->count();
        $userCount = AuthUser::find()->where(['status' => Constant::STATUS_ACTIVE])->count();

        return $this->render('index', compact(
            'ranhthuaCount',
            'userCount',
            'nonghoStatistic',
            'nonghoCount',
            'quytrinhSanxuatStatistic',
            'dientichSanxuatStatistic',
            'nonghoHanhchinhStatistic',
            'cosoCatraCount',
            'cosoCatraStatistic',
            'cosoCalongbeCount',
            'cosoCalongbeStatistic',
            'thuysanHanhchinhStatistic',
            'cosoNuoiheoCount',
            'channuoiHanhchinhStatistic'
        ));
    }

    // /**
    //  * Login action.
    //  *
    //  * @return Response|string
    //  */
    // public function actionLogin()
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->goHome();
    //     }

    //     $model = new LoginForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->login()) {
    //         return $this->goBack();
    //     }

    //     $model->password = '';
    //     return $this->render('login', [
    //         'model' => $model,
    //     ]);
    // }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
